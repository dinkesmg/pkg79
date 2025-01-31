@include('layouts.header')
<style>
    .password-input {
        position: relative;
    }

    .toggle-password {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
    }

    .toggle-password i {
        font-size: 16px;
        color: #999;
    }
</style>
<!-- @//section('content') -->

    <div class="container">
        <div class="row" style="display:flex; justify-content:center; align-items:center; height:100vh">
            <div class="col-md-6 col-sm-4">
                <div style="display:flex; justify-content:center;">
                    <h5 style="color:rgb(22 179 172); margin-bottom:10px; font-weight:bold;">PKG</h5>
                </div>
                <!-- <div>
                    <h5 style="color:##08BB20; margin-bottom:10px">Manajemen Layanan Terpadu Kinerja Pegawai Dinas Kesehatan Kota Semarang</h5>
                </div> -->

                <div class="box" style="display:flex; justify-content:center; align-items:center; border-radius:10px">
                    <form method="POST" action="{{ route('auth.cek') }}" style="margin:5px; padding: 45px; text-align: center; box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24); background-color:#FFFFFF; border-radius:10px;">
                        @csrf
                        <!-- <img class="nav-icon" src="{//{asset('asset')}}/apotek.png" style="width:70px; height:auto;"></img> -->
                        <h3 style="color:rgb(22 179 172); font-weight:bold">LOGIN</h3>
                        <hr></hr>
                        <div class="row" style="font-weight:bold; width:100%; margin-bottom:5px; margin-top:10px; display:inline-block; color:rgb(22 179 172)">Nama</div>
                        <div class="row" style="width:100%; margin-bottom:5px; margin-right:0px; margin-left:0px;"><input type="text" name="nama" id="nama" placeholder="nama" style="height:40px; width:100%; text-align: center; font-size:16px"/></div>
                        <div class="row" style="font-weight:bold; width:100%; margin-bottom:5px; display:inline-block; color:rgb(22 179 172)">Password</div>
                        <!-- <div class="row" style="width:100%; margin-bottom:20px; margin-right:0px; margin-left:0px;">
                            <input type="password" name="password" id="password" placeholder="password" style="height:40px; width:100%; text-align: center; font-size:16px"/>
                            <button type="button" id="togglePassword" onclick="togglePasswordVisibility()" style="height:40px; width:40px;">
                                <i class="fa fa-eye-slash" id="eyeIcon"></i>
                            </button>
                        </div> -->
                        <div class="row" style="width:100%; margin-bottom:20px; margin-right:0px; margin-left:0px;">
                            <div class="password-input" style="width:100%">
                                <input type="password" name="password" id="password" placeholder="Password" style="height:40px; width:100%; text-align: center; font-size:16px">
                                <span class="toggle-password" onclick="togglePasswordVisibility()">
                                    <i class="fas fa-eye-slash" id="eyeIcon"></i>
                                </span>
                            </div>
                        </div>
                        @if(session()->get('error')!=null)
                            <span class="text-danger">{{session()->get('error')}}</span>
                        @enderror
                        <button type="submit" style="background: rgb(22 179 172); cursor: pointer; font-weight: bold; width: 100%; border: 0; padding: 15px; color: #FFFFFF; font-size: 16px;">login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<!-- @//endsection -->

<script src="{{ asset('AdminLTE-3.2.0/plugins/jquery/jquery.min.js') }}"></script>
<script>
    function togglePasswordVisibility() {
        var passwordInput = document.getElementById('password');
        var eyeIcon = document.getElementById('eyeIcon');

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
        } else {
            passwordInput.type = "password";
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
        }
    }

</script>
