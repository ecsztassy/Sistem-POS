import './bootstrap';

import Alpine from 'alpinejs';
import DataTable from 'datatables.net-bs5';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';

const money = value => 'Rp. ' + Number(value || 0).toLocaleString('id-ID');
const language = {search:'Cari:',lengthMenu:'Tampilkan _MENU_ baris',info:'Menampilkan _START_–_END_ dari _TOTAL_ data',infoEmpty:'Belum ada data',emptyTable:'Belum ada data tersedia',zeroRecords:'Data tidak ditemukan',infoFiltered:'(dari _MAX_ data)',processing:'Memuat data...',paginate:{first:'Awal',last:'Akhir',next:'›',previous:'‹'}};

Alpine.data('posCart', () => ({
    search:'',searchUrl:'',products:[],cart:[],paid:0,loading:false,busy:false,error:'',abort:null,
    money,
    async init() {
        this.searchUrl = this.$el.dataset.searchUrl;
        this.paid = Number(this.$el.dataset.oldPaid || 0);
        const previous = JSON.parse(this.$el.dataset.oldItems || '[]');
        if (previous.length) {
            try {
                const url = new URL(this.searchUrl,location.origin);
                previous.forEach(line => url.searchParams.append('ids[]',line.item_id));
                const response = await fetch(url,{headers:{Accept:'application/json'}});
                if (!response.ok) throw new Error();
                const items = await response.json();
                this.cart = previous.flatMap(line => {
                    const item = items.find(item => item.id === Number(line.item_id));
                    return item ? [{...item,qty:Math.min(Number(line.qty),item.stock)}] : [];
                });
            } catch { this.error='Keranjang sebelumnya gagal dimuat. Silakan pilih barang kembali.'; }
        }
        await this.loadProducts();
    },
    async loadProducts() {
        this.abort?.abort(); this.abort = new AbortController();
        this.loading=true; this.error='';
        try {
            const url=new URL(this.searchUrl,location.origin); url.searchParams.set('q',this.search);
            const response=await fetch(url,{signal:this.abort.signal,headers:{Accept:'application/json'}});
            if (!response.ok) throw new Error();
            this.products=await response.json(); this.loading=false;
        } catch(error) {
            if (error.name!=='AbortError') { this.error='Barang gagal dimuat. Periksa koneksi dan coba cari kembali.';this.loading=false; }
        }
    },
    quantity(id) { return this.cart.find(line=>line.id===id)?.qty || 0; },
    add(item) {
        const line=this.cart.find(line=>line.id===item.id);
        if (line) { if (line.qty<item.stock) line.qty++; }
        else this.cart.push({...item,qty:1});
    },
    addFirst() { if (!this.loading && this.products.length===1) this.add(this.products[0]); },
    adjust(line,delta) { line.qty=Math.max(1,Math.min(line.stock,(Number(line.qty)||1)+delta)); },
    remove(id) { this.cart=this.cart.filter(line=>line.id!==id); },
    clear() { if (confirm('Kosongkan keranjang belanja?')) { this.cart=[];this.paid=0; } },
    get total() { return this.cart.reduce((sum,line)=>sum+Number(line.qty)*line.sell_price,0); },
    get valid() { return this.cart.length>0 && this.cart.every(line=>Number.isInteger(line.qty)&&line.qty>0&&line.qty<=line.stock) && Number.isInteger(this.paid) && this.paid>=this.total; },
    submit(event) { if (!this.valid || this.busy) event.preventDefault(); else this.busy=true; },
}));

document.addEventListener('DOMContentLoaded',()=>{
    document.querySelectorAll('table.datatable').forEach(table=>new DataTable(table,{language,order:[],columnDefs:[{targets:-1,orderable:false}]}));
    const table=document.getElementById('inventory-table');
    if (table) {
        const text=DataTable.render.text();
        new DataTable(table,{serverSide:true,processing:true,searchDelay:300,ordering:false,language,ajax:table.dataset.url,
            columns:[{data:'item_code',render:text},{data:'name',render:text},{data:'category',render:text},
                {data:'buy_price',render:money},{data:'sell_price',render:money},
                {data:'stock',render:(value,type,row)=>type==='display'?`<span class="badge ${value<=5?'badge-low':'badge-soft'}">${Number(value)}</span> <span class="small subtle">${text.display(row.unit)}</span>`:value},
                {data:'id',render:id=>{
                    const base=table.dataset.editUrl+'/'+Number(id);
                    const token=document.querySelector('meta[name="csrf-token"]').content;
                    return `<div class="text-nowrap"><a class="btn btn-sm btn-light border" href="${base}/edit">Edit</a> <form class="d-inline" method="POST" action="${base}" data-confirm="Arsipkan barang ini?"><input type="hidden" name="_token" value="${token}"><input type="hidden" name="_method" value="DELETE"><button class="btn btn-sm btn-outline-danger" aria-label="Arsipkan barang"><i class="fa-regular fa-trash-can"></i></button></form></div>`;
                }}],
        });
    }
    document.addEventListener('submit',event=>{
        const message=event.target.dataset.confirm;
        if (message && !confirm(message)) event.preventDefault();
    });
});

window.Alpine = Alpine;

Alpine.start();
