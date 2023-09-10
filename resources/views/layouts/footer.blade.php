<link rel="stylesheet" href="{{ asset('css/components/footer.css') }}">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
<footer class="site-footer">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <h6>About</h6>
                <p class="text-justify">AE Store</p>
            </div>
            <div class="col-xs-6 col-md-3">
                <h6>Info</h6>
                <ul class="footer-links">
                    <li><a href="">ss</a></li>
                </ul>
            </div>

            <div class="col-xs-6 col-md-3">
                <h6>Quick Links</h6>
                <ul class="footer-links">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="#">About Us</a></li>
                    <li><a href="{{ route('product.index') }}">Products</a></li>
                    @if (Auth::check())
                        <li><a href="{{ route('orders.index', Auth::user()->id) }}">Orders</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
    <hr>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-sm-6 col-xs-12">
                <p class="copyright-text">Copyright &copy; 2023 All Rights Reserved by
                    <a href="{{ route('home') }}"> AE Store</a>.
                </p>
            </div>

            <div class="col-md-4 col-sm-6 col-xs-12">
                <ul class="social-icons">
                    <li><a class="facebook" href="#"><i class="fab fa-facebook-f"></i></a></li>
                    <li><a class="twitter" href="#"><i class="fab fa-twitter"></i></a></li>
                    <li><a class="instagram" href="#"><i class="fab fa-instagram"></i></a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>
