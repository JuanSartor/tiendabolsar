
</div>
</div>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
<!--PIE DE PÁGINA-->
@if (!Auth::check() || Auth::user()->rol != 'admin')
<a href="https://wa.me/5493482683183" class="whatsapp-float" target="_blank" rel="noopener">
    <img src="https://img.icons8.com/ios-filled/50/25D366/whatsapp.png" alt="WhatsApp">
</a>
@endif
<footer  id = "footer">
    <div style="margin-left: 0px; margin-right: 0px;" class="row">
        <div class="col-md-4">
            <p>&copy; {{ date('Y') }} PA
            </p>
        </div>
        <div class="col-md-4">
            <div>
                <a class="f14mb" style="color: white; text-decoration: none;" href="{{url('/terminos-y-condiciones')}}">
                    Terminos y condiciones
                </a>
            </div>
            <div class="mg15mb">
                <a class="f14mb" style="color: white; text-decoration: none;" href="{{url('/politicas')}}">
                    Politicas de privacidad
                </a>
            </div>
        </div>
        <div class="col-md-4">
            <a style="color: black;" href="https://instagram.com/bolsarbolsasdepapel" target="_blank">
                <i class="bi bi-instagram" style="font-size: 24px; color: #E4405F;"></i>
            </a>
            <a style=" margin-left: 10px; margin-right: 10px; color: black;" href="https://facebook.com/tu_pagina" target="_blank">
                <i class="bi bi-facebook" style="font-size: 24px; color: #1877F2;"></i>
            </a>
            <a href="https://wa.me/5493482683183" target="_blank">
                <i class="bi bi-whatsapp" style="font-size: 24px; color: #25D366;"></i>
            </a>
        </div>

    </div>
</footer>
</div>
</body>
</html>


