<?php

include_once "header.php";

?>

<section class="content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2>Data Tractor
                </h2>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12">
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="index-2.html"><i class="zmdi zmdi-home"></i> GIS Tractor</a></li>
                    <li class="breadcrumb-item active">Tractor</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <!-- Basic Validation -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2>Form Data Tractor</h2>
                        <ul class="header-dropdown">
                            <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                                <ul class="dropdown-menu">
                                    <li><a href="list_informasi.php">Daftar Informasi</a></li>
                                </ul>
                            </li>
                            <li class="remove">
                                <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <div id="form_validation">
                            <div class="form-group form-float">
                                <input type="text" class="form-control" placeholder="Judul" id="judul" required>
                            </div>
                            <div class="form-group form-float">
                                <input type="text" class="form-control" placeholder="Konten" id="konten" required>
                            </div>
                            <button class="btn btn-raised btn-primary btn-round waves-effect" id="tambahData">SUBMIT</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# Basic Validation --> 
    </div>
</section>

<?php

include_once "footer.php";

?>

<script>
    var db = firebase.firestore();
    $('#tambahData').on('click', function () {
        var today = new Date();
        var date = today.getFullYear() + "-" + (today.getMonth() + 1) + "-" + today.getDate();
        var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
        var datetime = date + " " + time;
        judul = $('#judul').val();
        konten = $('#konten').val();
        $("#tambahData").addClass("disabled");
        db.collection("informations").add({
            judul: judul,
            konten: konten,
            created_at: datetime,
            updated_at: datetime,
        })
        .then(function(docRef) {
            $("#tambahData").removeClass("disabled");
            Swal.fire(
                'Status!',
                'Data Berhasil Ditambahkan!',
                'success'
            )
        })
        .catch(function(error) {
            console.log(error);
            $("#tambahData").removeClass("disabled");
            Swal.fire(
                'Status!',
                'Data Gagal Ditambahkan!',
                'error'
            )
        })
    });
</script>