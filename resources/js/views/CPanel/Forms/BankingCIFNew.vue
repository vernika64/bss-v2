<template>

<div>
    <div class="p-3 mb-3 bg-white border-t flex flex-row border-b">
        <h1 class="text-2xl italic">{{ judulNavbar }}</h1>
    </div>
    <div class="pr-6 pl-6 bg-white">
        <div class="grid lg:grid-cols-2 grid-cols-1 gap-4">
            <!-- Box Pertama -->
            <div class="pr-2 pl-2">
                <p class="pb-2">{{ propertyFormCIF.kd_tipe.label }}</p>
                <select class="border border-slate-400 shadow-md bg-white hover:shadow-blue-200 mb-2 pt-1 pb-1 pl-2 rounded-md w-full h-[50px]" v-model="formCIF.kd_tipe">
                    <option :value="''">-- Pilih Jenis Identitas --</option>
                    <option :value="'ktp'">KTP</option>
                    <option :value="'ktm'">KTM</option>
                </select>
                
                <div class="flex flex-row items-end">
                    <div class="flex-auto">
                        <p class="pb-2">{{ propertyFormCIF.kd_identitas.label }}</p>
                        <input type="text" class="border border-slate-400 shadow-md bg-white hover:shadow-blue-200 mb-2 pt-1 pb-1 pl-2 rounded-md w-full h-[50px]" placeholder="Kode Identitas sesuai dengan Kartu Identitas" v-model="formCIF.kd_identitas" />
                    </div>
                    <div class="flex-none ml-2">
                        <button class="bg-blue-600 text-white h-[50px] w-[70px] p-2 mb-2 rounded-lg" @click="cariDataId()">Cek</button>
                    </div>
                </div>
        
                <p class="pb-2">{{ propertyFormCIF.nama.label }}</p>
                <input type="text" class="border border-slate-400 shadow-md hover:shadow-blue-200 bg-white mb-2 pt-1 pb-1 pl-2 rounded-md w-full h-[50px]" placeholder="Nama Lengkap sesuai Kartu Identitas" v-model="formCIF.nama" />
        
                <p class="pb-2">{{ propertyFormCIF.tempat_lahir.label }}</p>
                <input type="text" class="border border-slate-400 shadow-md hover:shadow-blue-200 bg-white mb-2 pt-1 pb-1 pl-2 rounded-md w-full h-[50px]" placeholder="Tempat Lahir sesuai Kartu Identitas" v-model="formCIF.tempat_lahir" />
        
                <p class="pb-2">{{ propertyFormCIF.tgl_lahir.label }}</p>
                <input type="date" class="border border-slate-400 shadow-md hover:shadow-blue-200 bg-white mb-2 pt-1 pb-1 pl-2 rounded-md w-full h-[50px]" placeholder="Tanggal Lahir sesuai Kartu Identitas" v-model="formCIF.tgl_lahir" />
        
                <p class="pb-2">{{ propertyFormCIF.jenis_kelamin.label }}</p>
                <select class="border border-slate-400 shadow-md hover:shadow-blue-200 bg-white mb-2 pt-1 pb-1 pl-2 rounded-md w-full h-[50px]" v-model="formCIF.jenis_kelamin">
                    <option :value="''">-- Pilih Jenis Kelamin --</option>
                    <option :value="'laki'">Laki - Laki</option>
                    <option :value="'perempuan'">Perempuan</option>
                </select>
        
                <p class="pb-2">{{ propertyFormCIF.status_kawin.label }}</p>
                <select class="border border-slate-400 shadow-md hover:shadow-blue-200 bg-white mb-2 pt-1 pb-1 pl-2 rounded-md w-full h-[50px]" v-model="formCIF.status_kawin">
                    <option v-for="isi in isiSelect.statusKawin" :value="isi.value">{{ isi.label }}</option>
                </select>

                <p class="pb-2">{{ propertyFormCIF.negara.label }}</p>
                <input type="text" class="border border-slate-400 shadow-md hover:shadow-blue-200 bg-white pt-1 pb-1 pl-2 rounded-md w-full h-[50px]" placeholder="Kewarganegaraan sekarang. Contoh : Indonesia" v-model="formCIF.negara" />
                
                <div class="md:hidden lg:grid lg:grid-cols-2 lg:gap-2">
                    <button class="bg-blue-500 text-white p-3 mt-4 w-full rounded-lg shadow-md" @click="modalKonfirmasiStatus = true">Simpan</button>
                    <button class="bg-slate-200 text-black p-3 mt-4 w-full rounded-lg shadow-md" @click="resetData()">Reset</button>
                </div>

            </div>

            <!-- Box Kedua -->
            <div class="pr-2 pl-2">
    
                <p class="pb-2">{{ propertyFormCIF.alamat.label }}</p>
                <input type="text" class="border border-slate-400 shadow-md hover:shadow-blue-200 bg-white mb-2 pt-1 pb-1 pl-2 rounded-md w-full h-[50px]" placeholder="Alamat tempat tinggal sekarang" v-model="formCIF.alamat" />
    
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <p class="pb-2">{{ propertyFormCIF.rt_rw.label }}</p>
                        <input type="text" class="border border-slate-400 shadow-md hover:shadow-blue-200 bg-white mb-2 pt-1 pb-1 pl-2 w-full rounded-md h-[50px]" placeholder="RT / RW" v-model="formCIF.rt_rw" />
                    </div>
                    <div>
                        <p class="pb-2">{{ propertyFormCIF.desa_kelurahan.label }}</p>
                        <div class="flex flex-row">
                            <div class="flex-none">
                                <select class="border border-slate-400 bg-blue-600 text-white rounded-tl-md rounded-bl-md pl-2 h-[50px]">
                                    <option>Desa</option>
                                    <option>Kelurahan</option>
                                </select>
                            </div>
                            <div class="flex-auto">
                                <input type="text" class="border-t border-b border-r border-slate-400 bg-white mb-2 pt-1 pb-1 pl-2 w-full rounded-tr-md rounded-br-md h-[50px]" v-model="formCIF.desa_kelurahan" placeholder="Contoh : Pandanwangi" />
                            </div>
                        </div>
                    </div>
                </div>
    
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <p class="pb-2">{{ propertyFormCIF.kecamatan.label }}</p>
                        <input type="text" class="border border-slate-400 shadow-md hover:shadow-blue-200 bg-white mb-2 pt-1 pb-1 pl-2 rounded-md w-full h-[50px]" placeholder="Contoh : Kecamatan Blimbing" v-model="formCIF.kecamatan" />
                    </div>
                    <div>
                        <p class="pb-2">{{ propertyFormCIF.kabupaten_kota.label }}</p>
                        <input type="text" class="border border-slate-400 shadow-md hover:shadow-blue-200 bg-white mb-2 pt-1 pb-1 pl-2 rounded-md w-full h-[50px]" placeholder="Contoh : Kota Malang" v-model="formCIF.kabupaten_kota" />
                    </div>    
                </div>
    
                <p class="pb-2">{{ propertyFormCIF.provinsi.label }}</p>
                <input type="text" class="border border-slate-400 shadow-md hover:shadow-blue-200 bg-white mb-2 pt-1 pb-1 pl-2 rounded-md w-full h-[50px]" placeholder="Contoh : Jawa Timur" v-model="formCIF.provinsi" />
    
                <p class="pb-2">{{ propertyFormCIF.kode_pos.label }}</p>
                <input type="text" class="border border-slate-400 shadow-md hover:shadow-blue-200 bg-white mb-2 pt-1 pb-1 pl-2 rounded-md w-full h-[50px]" placeholder="Contoh : 65124" v-model="formCIF.kode_pos" />
    
                <p class="pb-2">{{ propertyFormCIF.no_telp.label }}</p>
                <input type="text" class="border border-slate-400 shadow-md hover:shadow-blue-200 bg-white mb-2 pt-1 pb-1 pl-2 rounded-md w-full h-[50px]" placeholder="Contoh : 083848261647" v-model="formCIF.no_telp" />
    
                <p class="pb-2">{{ propertyFormCIF.email.label }}</p>
                <input type="text" class="border border-slate-400 shadow-md hover:shadow-blue-200 bg-white mb-2 pt-1 pb-1 pl-2 rounded-md w-full h-[50px]" placeholder="Contoh : kucingterbang@gmail.com" v-model="formCIF.email" />
    
                <p class="pb-2">{{ propertyFormCIF.nama_ibu.label }}</p>
                <input type="text" class="border border-slate-400 shadow-md hover:shadow-blue-200 bg-white mb-2 pt-1 pb-1 pl-2 rounded-md w-full h-[50px]" placeholder="Nama Ibu Kandung Pelanggan" v-model="formCIF.nama_ibu" />
    
                <p class="pb-2">{{ propertyFormCIF.status_pekerjaan.label }}</p>
                <input type="text" class="border border-slate-400 shadow-md hover:shadow-blue-200 bg-white mb-2 pt-1 pb-1 pl-2 rounded-md w-full h-[50px]" placeholder="Pekerjaan sekarang" v-model="formCIF.status_pekerjaan" />

                <div class="lg:hidden md:grid md:grid-cols-2 md:gap-2 md:mb-5">
                    <button class="bg-blue-500 text-white p-3 mt-4 w-full rounded-lg shadow-md" @click="modalKonfirmasiStatus = true">Simpan</button>
                    <button class="bg-slate-200 text-black p-3 mt-4 w-full rounded-lg shadow-md" @click="resetData()">Reset</button>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Tambah CIF -->

<Transition name="slide-fade">
    <div class="flex flex-col w-full h-full bg-slate-900 left-0 top-0 fixed bg-opacity-70 justify-center align-middle" v-if="modalKonfirmasiStatus == true">
        <div class="relative bg-white rounded-lg shadow p-4 m-auto md:w-1/3 2xl:w-1/2">
            <div class="grid grid-rows-1">
                <h1 class="text-xl text-black mb-5">Konfirmasi CIF Baru</h1>
                <div class="grid grid-cols-2 gap-3 mb-4">
                    
                        <div class="flex bg-white shadow-lg rounded-lg border border-slate-300 p-2" :class="['' == formCIF.kd_tipe ? 'bg-red-600 text-white' : 'bg-white text-black']">
                            <div class="flex-auto">
                                <p class="text-md">{{ propertyFormCIF.kd_tipe.label }}</p>
                                <p class="text-lg">{{ '' != formCIF.kd_tipe ? translateTipeID(formCIF.kd_tipe) : 'Data kosong' }}</p>
                            </div>
                            <div class="flex-none m-auto">
                                <check-circle-icon class="h-7 w-7 fill-blue-700" v-if="'' != formCIF.kd_tipe"></check-circle-icon>
                                <x-circle-icon class="h-7 w-7 fill-white" v-else-if="'' == formCIF.kd_tipe"></x-circle-icon>
                            </div>
                        </div>
                        <div class="flex bg-white shadow-lg rounded-lg border border-slate-300 p-2" :class="['' == formCIF.kd_identitas ? 'bg-red-600 text-white' : 'bg-white text-black']">
                            <div class="flex-auto">
                                <p class="text-md">{{ propertyFormCIF.kd_identitas.label }}</p>
                                <p class="text-lg">{{ '' != formCIF.kd_identitas ? formCIF.kd_identitas : 'Data kosong' }}</p>
                            </div>
                            <div class="flex-none m-auto">
                                <check-circle-icon class="h-7 w-7 fill-blue-700" v-if="'' != formCIF.kd_identitas"></check-circle-icon>
                                <x-circle-icon class="h-7 w-7 fill-white" v-else-if="'' == formCIF.kd_identitas"></x-circle-icon>
                            </div>
                        </div>
                        <div class="flex bg-white shadow-lg rounded-lg border border-slate-300 p-2" :class="['' == formCIF.nama ? 'bg-red-600 text-white' : 'bg-white text-black']">
                            <div class="flex-auto">
                                <p class="text-md">{{ propertyFormCIF.nama.label }}</p>
                                <p class="text-lg">{{ '' != formCIF.nama ? formCIF.nama : 'Data kosong' }}</p>
                            </div>
                            <div class="flex-none m-auto">
                                <check-circle-icon class="h-7 w-7 fill-blue-700" v-if="'' != formCIF.nama"></check-circle-icon>
                                <x-circle-icon class="h-7 w-7 fill-white" v-else-if="'' == formCIF.nama"></x-circle-icon>
                            </div>
                        </div>
                        <div class="flex bg-white shadow-lg rounded-lg border border-slate-300 p-2" :class="['' == formCIF.tempat_lahir ? 'bg-red-600 text-white' : 'bg-white text-black']">
                            <div class="flex-auto">
                                <p class="text-md">{{ propertyFormCIF.tempat_lahir.label }}</p>
                                <p class="text-lg">{{ '' != formCIF.tempat_lahir ? formCIF.tempat_lahir : 'Data kosong' }}</p>
                            </div>
                            <div class="flex-none m-auto">
                                <check-circle-icon class="h-7 w-7 fill-blue-700" v-if="'' != formCIF.tempat_lahir"></check-circle-icon>
                                <x-circle-icon class="h-7 w-7 fill-white" v-else-if="'' == formCIF.tempat_lahir"></x-circle-icon>
                            </div>
                        </div>
                        <div class="flex bg-white shadow-lg rounded-lg border border-slate-300 p-2" :class="['' == formCIF.tgl_lahir ? 'bg-red-600 text-white' : 'bg-white text-black']">
                            <div class="flex-auto">
                                <p class="text-md">{{ propertyFormCIF.tgl_lahir.label }}</p>
                                <p class="text-lg">{{ '' != formCIF.tgl_lahir ? formCIF.tgl_lahir : 'Data kosong' }}</p>
                            </div>
                            <div class="flex-none m-auto">
                                <check-circle-icon class="h-7 w-7 fill-blue-700" v-if="'' != formCIF.tgl_lahir"></check-circle-icon>
                                <x-circle-icon class="h-7 w-7 fill-white" v-else-if="'' == formCIF.tgl_lahir"></x-circle-icon>
                            </div>
                        </div>
                        <div class="flex bg-white shadow-lg rounded-lg border border-slate-300 p-2" :class="['' == formCIF.jenis_kelamin ? 'bg-red-600 text-white' : 'bg-white text-black']">
                            <div class="flex-auto">
                                <p class="text-md">{{ propertyFormCIF.jenis_kelamin.label }}</p>
                                <p class="text-lg">{{ '' != formCIF.jenis_kelamin ? translateJenisKelamin(formCIF.jenis_kelamin) : 'Data kosong' }}</p>
                            </div>
                            <div class="flex-none m-auto">
                                <check-circle-icon class="h-7 w-7 fill-blue-700" v-if="'' != formCIF.jenis_kelamin"></check-circle-icon>
                                <x-circle-icon class="h-7 w-7 fill-white" v-else-if="'' == formCIF.jenis_kelamin"></x-circle-icon>
                            </div>
                        </div>
                        <div class="flex bg-white shadow-lg rounded-lg border border-slate-300 p-2" :class="['' == formCIF.status_kawin ? 'bg-red-600 text-white' : 'bg-white text-black']">
                            <div class="flex-auto">
                                <p class="text-md">{{ propertyFormCIF.status_kawin.label }}</p>
                                <p class="text-lg">{{ '' != formCIF.status_kawin ? translateStatusKawin(formCIF.status_kawin) : 'Data kosong' }}</p>
                            </div>
                            <div class="flex-none m-auto">
                                <check-circle-icon class="h-7 w-7 fill-blue-700" v-if="'' != formCIF.status_kawin"></check-circle-icon>
                                <x-circle-icon class="h-7 w-7 fill-white" v-else-if="'' == formCIF.status_kawin"></x-circle-icon>
                            </div>
                        </div>
                        <div class="flex bg-white shadow-lg rounded-lg border border-slate-300 p-2" :class="['' == formCIF.negara ? 'bg-red-600 text-white' : 'bg-white text-black']">
                            <div class="flex-auto">
                                <p class="text-md">{{ propertyFormCIF.negara.label }}</p>
                                <p class="text-lg">{{ '' != formCIF.negara ? formCIF.negara : 'Data kosong' }}</p>
                            </div>
                            <div class="flex-none m-auto">
                                <check-circle-icon class="h-7 w-7 fill-blue-700" v-if="'' != formCIF.negara"></check-circle-icon>
                                <x-circle-icon class="h-7 w-7 fill-white" v-else-if="'' == formCIF.negara"></x-circle-icon>
                            </div>
                        </div>
                        <div class="flex bg-white shadow-lg rounded-lg border border-slate-300 p-2" :class="['' == formCIF.alamat ? 'bg-red-600 text-white' : 'bg-white text-black']">
                            <div class="flex-auto">
                                <p class="text-md">{{ propertyFormCIF.alamat.label }}</p>
                                <p class="text-lg">{{ '' != formCIF.alamat ? formCIF.alamat : 'Data kosong' }}</p>
                            </div>
                            <div class="flex-none m-auto">
                                <check-circle-icon class="h-7 w-7 fill-blue-700" v-if="'' != formCIF.alamat"></check-circle-icon>
                                <x-circle-icon class="h-7 w-7 fill-white" v-else-if="'' == formCIF.alamat"></x-circle-icon>
                            </div>
                        </div>
                        <div class="flex bg-white shadow-lg rounded-lg border border-slate-300 p-2" :class="['' == formCIF.rt_rw ? 'bg-red-600 text-white' : 'bg-white text-black']">
                            <div class="flex-auto">
                                <p class="text-md">{{ propertyFormCIF.rt_rw.label }}</p>
                                <p class="text-lg">{{ '' != formCIF.rt_rw ? formCIF.rt_rw : 'Data kosong' }}</p>
                            </div>
                            <div class="flex-none m-auto">
                                <check-circle-icon class="h-7 w-7 fill-blue-700" v-if="'' != formCIF.rt_rw"></check-circle-icon>
                                <x-circle-icon class="h-7 w-7 fill-white" v-else-if="'' == formCIF.rt_rw"></x-circle-icon>
                            </div>
                        </div>
                        <div class="flex bg-white shadow-lg rounded-lg border border-slate-300 p-2" :class="['' == formCIF.desa_kelurahan ? 'bg-red-600 text-white' : 'bg-white text-black']">
                            <div class="flex-auto">
                                <p class="text-md">{{ propertyFormCIF.desa_kelurahan.label }}</p>
                                <p class="text-lg">{{ '' != formCIF.desa_kelurahan ? formCIF.desa_kelurahan : 'Data kosong' }}</p>
                            </div>
                            <div class="flex-none m-auto">
                                <check-circle-icon class="h-7 w-7 fill-blue-700" v-if="'' != formCIF.desa_kelurahan"></check-circle-icon>
                                <x-circle-icon class="h-7 w-7 fill-white" v-else-if="'' == formCIF.desa_kelurahan"></x-circle-icon>
                            </div>
                        </div>
                        <div class="flex bg-white shadow-lg rounded-lg border border-slate-300 p-2" :class="['' == formCIF.kecamatan ? 'bg-red-600 text-white' : 'bg-white text-black']">
                            <div class="flex-auto">
                                <p class="text-md">{{ propertyFormCIF.kecamatan.label }}</p>
                                <p class="text-lg">{{ '' != formCIF.kecamatan ? formCIF.kecamatan : 'Data kosong' }}</p>
                            </div>
                            <div class="flex-none m-auto">
                                <check-circle-icon class="h-7 w-7 fill-blue-700" v-if="'' != formCIF.kecamatan"></check-circle-icon>
                                <x-circle-icon class="h-7 w-7 fill-white" v-else-if="'' == formCIF.kecamatan"></x-circle-icon>
                            </div>
                        </div>
                        <div class="flex bg-white shadow-lg rounded-lg border border-slate-300 p-2" :class="['' == formCIF.kabupaten_kota ? 'bg-red-600 text-white' : 'bg-white text-black']">
                            <div class="flex-auto">
                                <p class="text-md">{{ propertyFormCIF.kabupaten_kota.label }}</p>
                                <p class="text-lg">{{ '' != formCIF.kabupaten_kota ? formCIF.kabupaten_kota : 'Data kosong' }}</p>
                            </div>
                            <div class="flex-none m-auto">
                                <check-circle-icon class="h-7 w-7 fill-blue-700" v-if="'' != formCIF.kabupaten_kota"></check-circle-icon>
                                <x-circle-icon class="h-7 w-7 fill-white" v-else-if="'' == formCIF.kabupaten_kota"></x-circle-icon>
                            </div>
                        </div>
                        <div class="flex bg-white shadow-lg rounded-lg border border-slate-300 p-2" :class="['' == formCIF.provinsi ? 'bg-red-600 text-white' : 'bg-white text-black']">
                            <div class="flex-auto">
                                <p class="text-md">{{ propertyFormCIF.provinsi.label }}</p>
                                <p class="text-lg">{{ '' != formCIF.provinsi ? formCIF.provinsi : 'Data kosong' }}</p>
                            </div>
                            <div class="flex-none m-auto">
                                <check-circle-icon class="h-7 w-7 fill-blue-700" v-if="'' != formCIF.provinsi"></check-circle-icon>
                                <x-circle-icon class="h-7 w-7 fill-white" v-else-if="'' == formCIF.provinsi"></x-circle-icon>
                            </div>
                        </div>
                        <div class="flex bg-white shadow-lg rounded-lg border border-slate-300 p-2" :class="['' == formCIF.kode_pos ? 'bg-red-600 text-white' : 'bg-white text-black']">
                            <div class="flex-auto">
                                <p class="text-md">{{ propertyFormCIF.kode_pos.label }}</p>
                                <p class="text-lg">{{ '' != formCIF.kode_pos ? formCIF.kode_pos : 'Data kosong' }}</p>
                            </div>
                            <div class="flex-none m-auto">
                                <check-circle-icon class="h-7 w-7 fill-blue-700" v-if="'' != formCIF.kode_pos"></check-circle-icon>
                                <x-circle-icon class="h-7 w-7 fill-white" v-else-if="'' == formCIF.kode_pos"></x-circle-icon>
                            </div>
                        </div>
                        <div class="flex bg-white shadow-lg rounded-lg border border-slate-300 p-2" :class="['' == formCIF.no_telp ? 'bg-red-600 text-white' : 'bg-white text-black']">
                            <div class="flex-auto">
                                <p class="text-md">{{ propertyFormCIF.no_telp.label }}</p>
                                <p class="text-lg">{{ '' != formCIF.no_telp ? formCIF.no_telp : 'Data kosong' }}</p>
                            </div>
                            <div class="flex-none m-auto">
                                <check-circle-icon class="h-7 w-7 fill-blue-700" v-if="'' != formCIF.no_telp"></check-circle-icon>
                                <x-circle-icon class="h-7 w-7 fill-white" v-else-if="'' == formCIF.no_telp"></x-circle-icon>
                            </div>
                        </div>
                        <div class="flex bg-white shadow-lg rounded-lg border border-slate-300 p-2" :class="['' == formCIF.email ? 'bg-red-600 text-white' : 'bg-white text-black']">
                            <div class="flex-auto">
                                <p class="text-md">{{ propertyFormCIF.email.label }}</p>
                                <p class="text-lg">{{ '' != formCIF.email ? formCIF.email : 'Data kosong' }}</p>
                            </div>
                            <div class="flex-none m-auto">
                                <check-circle-icon class="h-7 w-7 fill-blue-700" v-if="'' != formCIF.email"></check-circle-icon>
                                <x-circle-icon class="h-7 w-7 fill-white" v-else-if="'' == formCIF.email"></x-circle-icon>
                            </div>
                        </div>
                        <div class="flex bg-white shadow-lg rounded-lg border border-slate-300 p-2" :class="['' == formCIF.nama_ibu ? 'bg-red-600 text-white' : 'bg-white text-black']">
                            <div class="flex-auto">
                                <p class="text-md">{{ propertyFormCIF.nama_ibu.label }}</p>
                                <p class="text-lg">{{ '' != formCIF.nama_ibu ? formCIF.nama_ibu : 'Data kosong' }}</p>
                            </div>
                            <div class="flex-none m-auto">
                                <check-circle-icon class="h-7 w-7 fill-blue-700" v-if="'' != formCIF.nama_ibu"></check-circle-icon>
                                <x-circle-icon class="h-7 w-7 fill-white" v-else-if="'' == formCIF.nama_ibu"></x-circle-icon>
                            </div>
                        </div>
                        <div class="flex bg-white shadow-lg rounded-lg border border-slate-300 p-2" :class="['' == formCIF.status_pekerjaan ? 'bg-red-600 text-white' : 'bg-white text-black']">
                            <div class="flex-auto">
                                <p class="text-md">{{ propertyFormCIF.status_pekerjaan.label }}</p>
                                <p class="text-lg">{{ '' != formCIF.status_pekerjaan ? formCIF.status_pekerjaan : 'Data kosong' }}</p>
                            </div>
                            <div class="flex-none m-auto">
                                <check-circle-icon class="h-7 w-7 fill-blue-700" v-if="'' != formCIF.status_pekerjaan"></check-circle-icon>
                                <x-circle-icon class="h-7 w-7 fill-white" v-else-if="'' == formCIF.status_pekerjaan"></x-circle-icon>
                            </div>
                        </div>
                    
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <button class="bg-slate-300 text-black p-2 rounded-md shadow-md" @click="modalKonfirmasiStatus = false">Batal</button>
                <button class="bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-md shadow-md" @click="simpanCIF()">Simpan</button>
            </div>
        </div>
    </div>
</Transition>

</template>


<script>
import axios from 'axios'

import { CheckCircleIcon, XCircleIcon } from '@heroicons/vue/solid'

export default {
    components: {
        CheckCircleIcon, XCircleIcon
    },
    mounted() {
        // 
    },
    data() {
        return {
            judulNavbar         : 'Tambah Data CIF Baru',
            formCIF             : {
                kd_identitas        : '',
                kd_tipe             : '',
                nama                : '',
                tempat_lahir        : '',
                tgl_lahir           : '',
                jenis_kelamin       : '',
                status_kawin        : '',
                negara              : '',
                alamat              : '',
                rt_rw               : '',
                desa_kelurahan      : '',
                kecamatan           : '',
                kabupaten_kota      : '',
                provinsi            : '',
                kode_pos            : '',
                no_telp             : '',
                email               : '',
                nama_ibu            : '',
                status_pekerjaan    : ''
            },
            dummyFormCIF        : {
                tgl_lahir           : '',
            },
            propertyFormCIF            : {
                kd_identitas        : {
                    label           : 'Kode Identitas',
                    status          : ''
                },
                kd_tipe             : {
                    label           : 'Tipe Identitas',
                    status          : ''
                },
                nama                : {
                    label           : 'Nama sesuai Identitas',
                    status          : ''
                },
                tempat_lahir        : {
                    label           : 'Tempat Lahir',
                    status          : ''
                },
                tgl_lahir           : {
                    label           : 'Tanggal Lahir',
                    status          : '',
                },
                jenis_kelamin       : {
                    label           : 'Jenis Kelamin',
                    status          : ''
                },
                status_kawin        : {
                    label           : 'Status Kawin',
                    status          : ''
                },
                negara              : {
                    label           : 'Kewarganegaraan',
                    status          : ''
                },
                alamat              : {
                    label           : 'Alamat domisil sekarang',
                    status          : ''
                },
                rt_rw               : {
                    label           : 'RT / RW',
                    status          : ''
                },
                desa_kelurahan      : {
                    label           : 'Desa / Kelurahan',
                    status          : ''
                },
                kecamatan           : {
                    label           : 'Kecamatan',
                    status          : ''
                },
                kabupaten_kota      : {
                    label           : 'Kabupaten / Kota',
                    status          : ''
                },
                provinsi            : {
                    label           : 'Provinsi',
                    status          : ''
                },
                kode_pos            : {
                    label           : 'Kode Pos',
                    status          : ''
                },
                no_telp             : {
                    label           : 'No. Telp',
                    status          : ''
                },
                email               : {
                    label           : 'E-Mail',
                    status          : ''
                },
                nama_ibu            : {
                    label           : 'Nama Ibu Kandung',
                    status          : ''
                },
                status_pekerjaan    : {
                    label           : 'Status Pekerjaan',
                    status          : ''
                }
            },
            modalKonfirmasiStatus   : false,
            isiSelect               : {
                statusKawin         : [
                    {
                        label       : '-- Pilih Status Kawin --',
                        value       : '',
                    },
                    {
                        label       : 'Belum Menikah',
                        value       : 'belum',
                    },
                    {
                        label       : 'Menikah',
                        value       : 'sudah',
                    },
                    {
                        label       : 'Janda',
                        value       : 'janda',
                    },
                    {
                        label       : 'Duda',
                        value       : 'duda',
                    },
                ]
            }
        }
    },
    methods: {
        simpanCIF() {

            var pesan = confirm("Apakah anda sudah yakin data CIF sudah benar ?")

            if(pesan == true) {
                console.log('simpan')
                console.log(this.formCIF)

                axios.post('/api/bank/tambahCIF', this.formCIF).then(insert => {
                    alert(insert.data.message)
                    console.log(insert.data)

                    return this.$router.push({name: 'CIF'})
                }).catch(error => {
                    console.log(error)
                })
            } else if(pesan == false) {
                console.log('batal')
            } else {
                console.log('error')
            }
        },
        cariDataId() {
            var tipeID  = this.formCIF.kd_tipe
            var nomerID = this.formCIF.kd_identitas

            if(tipeID != '' && nomerID != '') {
                axios.post('/api/bank/cekStatusCIF', { tipe_id : tipeID, nomer_id : nomerID }).then(dt => {
                    console.log(dt)
                    return alert(dt.data.message)
                }).catch(err => {
                    console.log(err)
                    return alert('Terjadi kesalahan dalam cek data, silahkan coba lagi')
                })
            } else {
                return alert('Mohon diisi Tipe Identitas dan Kode Identitas terlebih dahulu sebelum mengecek ketersediaan Identitas')
            }

        },
        translateTipeID(data) {
            switch (data) {
                case '':
                    return 'Data kosong'
                case 'ktp':
                    return 'Kartu Tanda Penduduk'
                case 'ktm':
                    return 'Kartu Tanda Mahasiswa'
                default:
                    return 'Data kosong'
            }
        },
        translateStatusKawin(data) {
            switch (data) {
                case '':
                    return 'Data kosong'
                case 'belum':
                    return 'Belum Menikah'
                case 'sudah':
                    return 'Menikah'
                case 'janda':
                    return 'Janda'
                case 'duda':
                    return 'Duda'
                default:
                    return 'Data kosong'
            }
        },
        translateJenisKelamin(data) {
            switch (data) {
                case '':
                    return 'Data kosong'
                case 'laki':
                    return 'Laki - Laki'
                case 'perempuan':
                    return 'Perempuan'
                default:
                    return 'Data kosong'
            }
        },
        resetData() {
            var konfirmasi  = confirm('Apakah anda yakin untuk mereset data di form ?')

            if(konfirmasi == true)
            {
                this.formCIF.kd_identitas        = ''
                this.formCIF.kd_tipe             = ''
                this.formCIF.nama                = ''
                this.formCIF.tempat_lahir        = ''
                this.formCIF.tgl_lahir           = ''
                this.formCIF.jenis_kelamin       = ''
                this.formCIF.status_kawin        = ''
                this.formCIF.negara              = ''
                this.formCIF.alamat              = ''
                this.formCIF.rt_rw               = ''
                this.formCIF.desa_kelurahan      = ''
                this.formCIF.kecamatan           = ''
                this.formCIF.kabupaten_kota      = ''
                this.formCIF.provinsi            = ''
                this.formCIF.kode_pos            = ''
                this.formCIF.no_telp             = ''
                this.formCIF.email               = ''
                this.formCIF.nama_ibu            = ''
                this.formCIF.status_pekerjaan    = '' 
                
                // console.log('Form berhasil direset')
            } else {
                // Do Nothing
            }


        }
    }
}
</script>