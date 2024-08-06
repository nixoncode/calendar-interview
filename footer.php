<!-- Footer -->
<footer class="content-footer footer bg-footer-theme">
    <div class="container-xxl d-flex flex-wrap justify-content-center py-2 flex-md-row flex-row">
        <div class="">
            Powered by: <b><a href="https://vesencomputing.com/" target="_blank">Vesen Computing </b></a>
        </div>

        ©
        <strong> Copyright &copy; 2022
            <?php if (date('Y') != 2022) echo " - " . date('Y'); ?>
            <a class="footer-link fw-medium text-primary" href="https://vesencomputing.com/" target="_blank">VesenComputing Solutions</a>.
        </strong> All rights reserved.
    </div>
</footer>
<!-- / Footer -->

<div class="content-backdrop fade"></div>
</div>
<!-- Content wrapper -->
</div>
<!-- / Layout page -->
</div>

<!-- Overlay -->
<div class="layout-overlay layout-menu-toggle"></div>
</div>
<!-- / Layout wrapper -->
<?php include('includes/scripts.php') ?>

<script>
    function image_preview(my_img, img_loader) {
        $(function() {
            $(my_img).change(function(event) {
                let img = URL.createObjectURL(event.target.files[0]);
                $(img_loader).attr("src", img);
                console.log(event);
            });
        });
    }

    image_preview("#my_img", "#img_loader");
    image_preview("#my_image", "#image_loader");

    image_preview("#my_image1", "#image_loader1");
    image_preview("#my_image2", "#image_loader2");
    image_preview("#my_image3", "#image_loader3");
    image_preview("#my_image4", "#image_loader4");
    image_preview("#my_image5", "#image_loader5");
    image_preview("#my_image6", "#image_loader6");
    image_preview("#my_image7", "#image_loader7");
    image_preview("#my_image8", "#image_loader8");
    image_preview("#my_image9", "#image_loader9");
    image_preview("#my_image10", "#image_loader10");

    image_preview("#my_vid", "#vid_loader");
    image_preview("#menu", "#menu_loader");
</script>
</body>

</html>