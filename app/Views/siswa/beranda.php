<!DOCTYPE html>
<html lang="en">
    <?= $this->include('siswa/partisi/head.php'); ?>
    <style>
        .nav>li>a {
            padding-top: 5px;
            padding-bottom: 5px;
        }
        canvas {
            max-width: 100%;
            height: auto;
        }
    </style>
    <body>
    <?= $this->include('siswa/partisi/navbar.php'); ?>
    <?php use App\Models\ModelsAdmin; $modell = new ModelsAdmin(); ?>
        <div class="container px-4 px-lg-5">
        
            <nav class="navbar navbar-light bg-light mb-3">

                <nav class="nav">
                    <a class="nav-link disabled" href="#">Beranda</a>
                </nav>

            </nav>

            <div class="row justify-content-center d-flex">
            <?php foreach ($app as $x): ?>
                <div class="col-sm">
                    <div class="card bg-primary mb-3 text-white" style="max-width: 18rem;">
                        <div class="card-header">
                            Kampus
                        </div>
                        <div class="card-body">
                            <?= $x->nama_instansi; ?>
                        </div>
                    </div>
                    
                </div>

                <div class="col-sm">
                    
                    <div class="card bg-info mb-3 text-white" style="max-width: 18rem;">
                        <div class="card-header">
                            Dekan
                        </div>
                        <div class="card-body">
                            <?= $x->kepala_sekolah; ?>
                        </div>
                    </div>
                    
                </div>

            <?php endforeach; ?>

                <div class="col-sm">
                    
                    <div class="card bg-success mb-3 text-white" style="max-width: 18rem;">
                        <div class="card-header">
                            Pilihan Industri
                        </div>
                        <div class="card-body">
                            <?php if(!empty($modell->getNamaIndustriByIdSiswa($_SESSION['id_siswa']))): ?>
                                <?= $modell->getNamaIndustriByIdSiswa($_SESSION['id_siswa']); ?>
                            <?php else: ?>
                                BELUM DAFTAR
                            <?php endif; ?>
                        </div>
                    </div>
                    
                </div>

            </div>

                <div class="row justify-content-center d-flex">

                    <div class="col">
                        
                        <div class="card bg-dark mb-3 text-white">
                            <div class="card-header">
                                Pembimbing Industri
                            </div>
                            <div class="card-body">
                            <?php foreach($total_pembimbingindustri as $x): ?>
                            <?= $x->nama_pembimbing. "(".$x->nohp.")<br>"; ?>
                            <?php endforeach; ?>
                            </div>
                        </div>
                        
                    </div>

                    <div class="col">
                        
                        <div class="card bg-light mb-3 text-black">
                            <div class="card-header">
                                Pembimbing
                            </div>
                            <div class="card-body">
                            <?php foreach($total_pembimbingsekolah  as $x): ?>
                            <?= $x->nama_pembimbing." (".$x->nohp.")<br>"; ?>
                            <?php endforeach; ?>                          
                          </div>
                        </div>
                        
                    </div>


                </div>

            <div class="card mb-3">
                <div class="card-header">
                    Profil Saya
                </div>
                <div class="card-body">
                    <?php foreach($data_siswa as $x): ?>
                        <form id="UpdateProfil">
                            <div class="form-group">
                                <label for="nis">NIM</label>
                                <input type="text" readonly class="form-control" required value="<?= $x->nis; ?>">
                            </div>
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" class="form-control" readonly required value="<?= $x->nama_siswa; ?>">
                            </div>
                            <div class="form-group">
                                <label for="nama">Kelas</label>
                                <input type="text" class="form-control" readonly required value="<?= $x->nama_kelas; ?>">
                            </div>
                            <div class="form-group">
                                <label for="nama">Prodi</label>
                                <input type="text" class="form-control" readonly required value="<?= $x->nama_jurusan; ?>">
                            </div>
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" readonly id="username" name="username" required value="<?= $x->username; ?>">
                            </div>
                        </form>
                    <?php endforeach; ?>
                </div>
                <div class="card-footer">
                    <small id="password" class="form-text text-muted">Jika data diatas masih belum sesuai, silahkan hubungi admin</small>
                </div>
            </div>

            <div class="row mb-5">
                <div class="col-sm">
                    <div class="card">
                        <div class="card-header bg-white">
                            Kehadiran
                        </div>
                        <div class="card-body">
                            <canvas id="kehadiran"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-sm">
                    <div class="card">
                        <div class="card-header bg-white">
                            Jurnal
                        </div>
                        <div class="card-body">
                            <canvas id="jurnal"></canvas>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <?= $this->include('siswa/partisi/js.php'); ?>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            $(document).ready(function(){

                $('#UpdateProfil').submit(function(e){
                    e.preventDefault();

                    $.ajax({
                        url: '<?= base_url('siswa/updatesiswa') ?>',
                        type: 'POST',
                        data: $(this).serialize(),
                        success: function(res){
                            swal(res)
                            .then((result) => {
                                location.reload();
                            }).catch((err) => {
                                
                            });
                        },
                        error: function(err){
                            console.log(err);
                        }
                    });

                });

                $.ajax({
                    url: '<?= base_url('siswa/getAbsensiPerSiswa');?>',
                    success: function(res){
                        var data = JSON.parse(res);

                        const ArrKehadian = [0, 0, 0, 0, 0];

                        for (let i = 0; i < data.length; i++) {

                            if(data[i].status == "hadir"){

                                ArrKehadian[0] = ArrKehadian[0] + 1; 

                            }else if(data[i].status == "sakit"){

                                ArrKehadian[1] = ArrKehadian[1] + 1;

                            }else if(data[i].status == "ijin"){

                                ArrKehadian[2] = ArrKehadian[2] + 1;

                            }else if(data[i].status == "alfa"){

                                ArrKehadian[3] = ArrKehadian[3] + 1;

                            }else if(data[i].status == "pending"){

                                ArrKehadian[4] = ArrKehadian[4] + 1;

                            }

                        }


                        const SetupKehadiran = {
                            labels: [
                                'Hadir',
                                'Sakit',
                                'Izin',
                                'Alfa',
                                'Pending'
                            ],
                            datasets: [{
                                label: 'My First Dataset',
                                data: ArrKehadian,
                                backgroundColor: [
                                'rgb(43, 181, 105)',
                                'rgb(43, 119, 181)',
                                'rgb(230, 197, 16)',
                                'rgb(186, 37, 37)',
                                'rgb(255, 153, 102)',
                                ],
                                hoverOffset: 2
                            }]
                        }

                        const ConfigKehadiran = {
                            type : 'pie',
                            data : SetupKehadiran
                        }
                        
                        var ChartKehadiran = new Chart(
                            document.getElementById('kehadiran'),
                            ConfigKehadiran
                        );


                    }, 
                    error : function(err){
                        alert('Error '+err);
                    }

                })


                //-----------------------------------

                $.ajax({
                    url : '<?= base_url('siswa/getJurnalPerSiswa'); ?>',
                    error : function(x){
                        alert('Error View Graph Jurnal  '+x);
                    },
                    success : function(res){
                        
                        var data = JSON.parse(res);
                        var ArrJurnal = [0, 0, 0];

                        for(let i = 0; i <data.length; i++){

                            if(data[i].status == "Y"){

                                ArrJurnal[0] = ArrJurnal[0] + 1;

                            }else if(data[i].status == "N"){

                                ArrJurnal[1] = ArrJurnal[1] + 1;

                            }else if(data[i].status == "P"){

                                ArrJurnal[2] = ArrJurnal[2] + 1;

                            }

                        }

                        const SetupJurnal = {
                            labels: [
                                'Approval',
                                'Unapproval',
                                'Pending'
                            ],
                            datasets: [{
                                labels:'Data Jurnal',
                                data: ArrJurnal,
                                backgroundColor: [
                                    'rgb(43, 181, 105)',
                                    'rgb(186, 37, 37)',
                                    'rgb(217, 202, 37)'
                                ],
                                hoverOffset: 2
                            }]
                        }
                        
                        const ConfigJurnal = {  
                            type : 'pie',
                            data :SetupJurnal
                        }

                        var ChartJurnal = new Chart(
                            document.getElementById('jurnal'),
                            ConfigJurnal
                        );

                    }

                })



            });
        </script>
    </body> 
</html>
