<!-- Form Validation -->
<script>
    // Form Validation
    (function() {
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.prototype.slice.call(forms)
            .forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
    })()

    $(function() {
        // Checkbox validation
        var requiredCheckboxes = $('.form-size :checkbox[required]');
        var checked = $('.form-size :checkbox[required]:checked');

        if (checked) requiredCheckboxes.removeAttr('required')
        requiredCheckboxes.change(function() {
            if (requiredCheckboxes.is(':checked')) {
                requiredCheckboxes.removeAttr('required');
            } else {
                requiredCheckboxes.attr('required', 'required');
            }
        });
    });
</script>

<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="../js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/uikit@3.9.4/dist/js/uikit.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/uikit@3.9.4/dist/js/uikit-icons.min.js"></script>

</body>

<footer>
    <div class="container containerfirstchild">
        <div class="row center-text">
            <div class="col-lg-4 col-md-6 col-xs-12">
                <h2 class="logo">Zay Shop</h2>
                <hr>
                <ul>
                    <li><i class="fas fa-map-pin"></i> 123 Consectetur at ligula 10660</li>
                    <li><a href="tel:010-020-0340"><i class="fas fa-phone-alt"></i> 010-020-0340</a></li>
                    <li><a href="mailto:info@company.com"><i class="fab fa-mailchimp"></i> info@company.com</a></li>
                </ul>
            </div>
            <div class="col-lg-4 col-md-6 col-xs-12">
                <h2>Products</h2>
                <hr>
                <ul>
                    <li><a href="#">Luxury</a></li>
                    <li><a href="#">Sport Wear</a></li>
                    <li><a href="#">Men's Shoes</a></li>
                    <li><a href="#">Women's Shoes</a></li>
                    <li><a href="#">Popular Dress</a></li>
                    <li><a href="#">Gym Accessories</a></li>
                    <li><a href="#">Sports Shoes</a></li>
                </ul>
            </div>
            <div class="col-lg-4 col-md-6 col-xs-12">
                <h2>Further Info</h2>
                <hr>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Shop</a></li>
                    <li><a href="#">FAQs</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>
            <div class="col-lg-12 col-md-6 col-xs-12 socialdiv">
                <hr>
                <div class="row socialcontainer">
                    <div class="col-lg-3 col-md-12">
                        <ul class="social d-flex">
                            <li><a href="">
                                    <div class="iconflex">
                                        <i class="fab fa-facebook-f"></i>
                                    </div>
                                </a>
                            </li>
                            <li><a href="">
                                    <div class="iconflex">
                                        <i class="fab fa-instagram"></i>
                                    </div>
                                </a>
                            </li>
                            <li><a href="">
                                    <div class="iconflex">
                                        <i class="fab fa-twitter"></i>
                                    </div>
                                </a>
                            </li>
                            <li><a href="">
                                    <div class="iconflex">
                                        <i class="fab fa-linkedin"></i>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-3 col-md-12">
                        <div class="input-group">
                            <input type="text" class="form-control inputmail" placeholder="Email address" aria-label="Recipient's username" aria-describedby="button-addon2">
                            <button class="btn subscribe" type="button" id="button-addon2">Subscribe</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="copyright">
        <div class="container">
            <p>Copyright  © 2021 Company Name | Designed by <a href="#">Template Mo</a></p>
        </div>
    </div>
</footer>

</html>