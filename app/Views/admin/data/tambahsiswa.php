<?= $this->extend('admin/v_admin'); ?>
<?= $this->section('content'); ?>
<div class="content-wrapper">
<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0">Tambah Mahasiswa</h1>
        </div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= base_url('admin/siswa'); ?>">Data Mahasiswa</a></li>
            <li class="breadcrumb-item active">Tambah Mahasiswa</li>
        </ol>
        </div>
    </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">

        <div class="card">
            <div class="card-header">
                Tambah Mahasiswa
            </div>

            <div class="card-body">
                <form id="TambahSiswa">

                    <div class="mb-3 row">
                        <label for="nis" class="col-sm-2 col-form-label">NIM</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="nis" placeholder="NIM" required>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="nama_kelas" class="col-sm-2 col-form-label">Nama Mahasiswa</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="nama_siswa" placeholder="Nama" required>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="nama_kelas" class="col-sm-2 col-form-label">Kelas / Prodi</label>
                        <div class="col-sm-10">
                            <select class="form-control" aria-label="Default select example" required name="id_kelas">
                                <option selected value="">- Pilih Kelas -</option>
                                <?php foreach ($kelas as $x): ?>
                                <option value="<?= $x->id_kelas; ?>"><?= $x->nama_kelas." / ".$x->nama_jurusan; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="nama_alumni" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                        <div class="col-sm-10">
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" name="jenis_kelamin" id="flexRadioDefault1" required value="L">
                                <label class="custom-control-label" for="flexRadioDefault1" style="font-weight: normal;">
                                    Laki - Laki
                                </label>
                                </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" name="jenis_kelamin" id="flexRadioDefault2" required value="P">
                                <label class="custom-control-label" for="flexRadioDefault2" style="font-weight: normal;">
                                    Perempuan
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="nis" class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="alamat" placeholder="Alamat" required>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="nis" class="col-sm-2 col-form-label">Username</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="username" placeholder="Username" required>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="nis" class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10 input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-eye toggle-password"></i></span>
                            </div>
                            <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
                        </div>
                    </div>

            </div>
            <div class="card-footer">
                <div class="float-right">
                    <button type="submit" class="btn btn-primary" id="submit">
                        Simpan
                    </button>

                    <button class="btn btn-primary" type="button" disabled id="loading">
                        <span class="visually-hidden">Loading...</span>
                    </button>
                </div>

            </div>
        </form>
        </div>

    </div>
</section>
</div>

<script>
$('document').ready(function(){
    $('#loading').hide();

    $('#TambahSiswa').submit(function(e){

        e.preventDefault();

        $.ajax({
            url : '<?= base_url('admin/tambahsiswa_action'); ?>',
            type : 'POST',
            data : $(this).serialize(),
            beforeSend : function(){
                $('#loading').show();
                $('#submit').hide();
            },
            complete : function(){
                $('#loading').hide();
                $('#submit').show();
            },
            success : function(e){
                swal(e);
                $('#TambahSiswa').trigger("reset");
            }

        });

    });
});

$(document).on('click', '.toggle-password', function() {
    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $("#password");
    input.attr('type') === 'password' ? input.attr('type','text') : input.attr('type','password')
});
</script>

<?= $this->endSection('content'); ?>