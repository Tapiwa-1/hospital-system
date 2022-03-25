<?php include("layout/navbar.php"); ?>
<div class="container home banner d-block d-md-none">
    <div class="row ">
        <h1 class="my-md-5 py-5 text-center">HIT Clinic</h1>
    </div>
</div>
<div class="container">
    <div class="row my-3 align-items-md-center d-none d-md-flex">
        <div class="col-md">
            <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="img/home.jpg" class="d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>First slide label</h5>
                            <p>Some representative placeholder content for the first slide.</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="img/home.jpg" class="d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Second slide label</h5>
                            <p>Some representative placeholder content for the second slide.</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="img/home.jpg" class="d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Third slide label</h5>
                            <p>Some representative placeholder content for the third slide.</p>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
        <div class="col-md text-md-center">
            <h1>Title here</h1>
            <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Dignissimos asperiores provident minus laborum tempore, dolorem cum placeat commodi nesciunt nobis nisi distinctio ad id vel, autem hic iste molestiae laudantium.</p>
        </div>
    </div>
    <div class="row">
        <div class="container headings text-md-center my-2">
            <h1>Vision</h1>
        </div>
        <div class="container-fluid">
            <div class="row align-items-md-center">
                <div class="col-md-3">
                    <img src="img/doctor-1.jpg" class="img-fluid d-none d-md-block" alt="">
                </div>
                <div class="col-md-9">
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Consectetur autem vel animi voluptate fugit rerum aliquid vero possimus vitae ex, qui laborum quidem quas ad tempore quod, assumenda ratione molestiae!</p>
                </div>
                <div class="container-fluid headings text-md-center my-2">
                    <h1>Mission</h1>
                </div>
                <div class="container-fluid">
                    <div class="row align-items-md-center">
                        <div class="col-md-9">
                            <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Consectetur autem vel animi voluptate fugit rerum aliquid vero possimus vitae ex, qui laborum quidem quas ad tempore quod, assumenda ratione molestiae!</p>
                        </div>
                        <div class="col-md-3">
                            <img src="img/doctor-2.jpg" class="img-fluid d-none d-md-block" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include("layout/footer.php"); ?>