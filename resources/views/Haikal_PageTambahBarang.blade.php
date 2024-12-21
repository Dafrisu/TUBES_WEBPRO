<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambahkan barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('css/haikal_manage.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        
        /* misc */
        .main-content{
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .headertitle {
            width: 100%;
            height: 50px;
            background-color: #658864;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
        }

        #headtitle {
            font-size: 24px;
            font-family: Arial, sans-serif;
        }

        #formbarang {
            margin-top: 20px;
            text-align: left;
            margin-left: 20px;
            font-size: 16px;
        }

        #formbarang input {
            width: 50%;
            height: auto;
            max-width: 500px;
        }
        .btn{
            background-color: #658864;
        }
    </style>
</head>

<body>
    <Sidebar-component></Sidebar-component>

    <div class="main-content">
        <div class="headertitle">
            <h2 id="headtitle">Tambah barang</h2>
            
        </div>
        <form id="formbarang">
            <div style="margin-bottom: 20px;">
                <p><label for="id_namabarang">Nama Barang</label></p>
                <p><input type="text" class="form-control" placeholder="Nama" id="id_namabarang" required></p>
            </div>
            <div style="margin-bottom: 20px;">
                <p><label for="id_harga">Harga Barang</label></p>
                <p><input type="number" class="form-control" placeholder="Harga" id="id_harga" required></p>
            </div>
            <div style="margin-bottom: 20px;">
                <p><label for="id_stok">Jumlah Barang</label></p>
                <p><input type="number" class="form-control" placeholder="QTY" id="id_stok" required></p>
            </div>
            <div style="margin-bottom: 20px;">
                <p><label for="id_gambar">Gambar Barang</label></p>
                <p><input type="file" id="id_gambar" accept="image/*"></p>
            </div>
            <div>
                    <button type="button" class="btn btn-primary" id="addbarangbtn">
                        Tambahkan Barang
                    </button>
            </div>
        </form> 
    </div>
    <script src="{{ asset('js/Dafa_Sidebar.js') }}"></script>
    <script src="{{ asset('js/Haikal_managebarang.js') }}"></script>

    <script>
        document.getElementById("formbarang").addEventListener("button", function(event){
            event.preventDefault();
            window.location.href = "Haikal_ManageBarang.html";
        })
        
    </script>
</body>

</html>