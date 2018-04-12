<!doctype html>
<html>
    <head>
        <title>harviacode.com - codeigniter crud generator</title>
        <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/>
        <style>
            body{
                padding: 15px;
            }
        </style>
    </head>
    <body>
        <h2 style="margin-top:0px">Guru Read</h2>
        <table class="table">
	    <tr><td>Nik</td><td><?php echo $nik; ?></td></tr>
	    <tr><td>Nama</td><td><?php echo $nama; ?></td></tr>
	    <tr><td>Matpel</td><td><?php echo $matpel; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('guru') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
        </body>
</html>