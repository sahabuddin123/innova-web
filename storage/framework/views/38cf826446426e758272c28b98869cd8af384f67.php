<?php $__env->startSection('title', 'ASSET Registration'); ?>

<?php $__env->startSection('content'); ?>

<style>

    body{
        background: #f4f7fb;
        /* font-family: 'SolaimanLipi', sans-serif; */
    }

    .asset-section{
        padding: 40px 0 80px;
    }

    .top-header{
        background: #d8edff;
        padding: 15px 25px;
        border-radius: 14px;
        margin-bottom: 35px;
    }

    .logo-img{
        height: 60px;
        object-fit: contain;
    }

    .main-title{
        font-size: 42px;
        font-weight: 700;
        color: #e53935;
        text-align: center;
        line-height: 1.5;
        margin-bottom: 50px;
    }

    .tab-btn{
        width: 100%;
        border: none;
        padding: 16px;
        border-radius: 12px;
        background: #666d78;
        color: #fff;
        font-size: 17px;
        font-weight: 700;
        transition: .3s;
    }

    .tab-btn.active{
        background: linear-gradient(135deg,#061c90,#051354);
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }

    .tab-btn:hover{
        transform: translateY(-2px);
    }

    .content-box{
        background: #fff;
        border-radius: 20px;
        padding: 45px;
        margin-top: 35px;
        box-shadow: 0 15px 40px rgba(0,0,0,0.06);
    }

    .section-title{
        font-size: 32px;
        font-weight: 700;
        color: #222;
        margin-bottom: 25px;
    }

    .content-box p{
        color: #555;
        line-height: 1.9;
        font-size: 16px;
    }

    .content-box li{
        margin-bottom: 12px;
        line-height: 1.9;
    }

    .course-table thead{
        background: #071875;
        color: #fff;
    }

    .custom-btn{
        background: linear-gradient(135deg,#071875,#05103f);
        border: none;
        color: #fff;
        padding: 12px 28px;
        border-radius: 10px;
        font-weight: 600;
    }

    .custom-btn:hover{
        color: #fff;
        opacity: .95;
    }

    .step-wrapper{
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 15px;
        margin: 35px 0 45px;
    }

    .step-box{
        border: 2px solid #102a72;
        padding: 18px 25px;
        border-radius: 12px;
        font-size: 20px;
        font-weight: 700;
        color: #102a72;
        background: #fff;
    }

    .form-control{
        height: 52px;
        border-radius: 10px;
        border: 1px solid #cfd7e2;
    }

    textarea.form-control{
        height: 130px;
    }

    .form-label{
        font-size: 14px;
        font-weight: 700;
        color: #555;
        margin-bottom: 8px;
    }

    .submit-btn{
        border: none;
        width: 220px;
        height: 55px;
        border-radius: 12px;
        background: linear-gradient(135deg,#0c2f68,#071d47);
        color: #fff;
        font-size: 18px;
        font-weight: 700;
    }

    .d-none-custom{
        display: none;
    }

    @media(max-width: 768px){

        .main-title{
            font-size: 28px;
        }

        .content-box{
            padding: 20px;
        }

        .section-title{
            font-size: 24px;
        }

        .step-box{
            width: 100%;
            text-align: center;
            font-size: 17px;
        }

    }
    .text-center{
        text-align: center;
    }
    ul{
        padding-left: 20px;
        list-style: disc;
    }
</style>

<div class="asset-section">

    <div class="container">

        
        <div class="top-header gap-3 text-center">
            <img src="<?php echo e(asset('./frontend/v2/assets/images/logo/asset-logo.png')); ?>" alt="ASSET Logo" class="logo-img">
            <!--<h4 class="mb-0 font-weight-bold text-center" style="color: #071875;">-->
            <!--    ASSET - Innova Computers Institute এর ফ্রি স্কিল ট্রেনিং প্রোগ্রাম রেজিস্ট্রেশন-->
            <!--</h4>-->
        </div>



        
        <div class="row">

            <div class="col-md-4 mb-3">
                <button class="tab-btn " id="btn_overview">
                    ASSET সম্পর্কে
                </button>
            </div>

            <div class="col-md-4 mb-3">
                <button class="tab-btn" id="btn_admission">
                    ভর্তি প্রক্রিয়া
                </button>
            </div>

            <div class="col-md-4 mb-3">
                <button class="tab-btn active" id="btn_registration">
                    রেজিস্ট্রেশন ফর্ম
                </button>
            </div>

        </div>

        
        <div class="content-box tab-content-area d-none-custom" id="overview-tab">
            <?php echo $__env->make('frontend.v2.asset.partials.overview', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

        
        <div class="content-box tab-content-area d-none-custom" id="admission-tab">
            <?php echo $__env->make('frontend.v2.asset.partials.admission', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

        
        <div class="content-box tab-content-area " id="registration-tab">
            <?php echo $__env->make('frontend.v2.asset.partials.registration', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

    </div>

</div>
<script>
    // let testBtn = document.getElementById('btn_overview');
    // testBtn.addEventListener('click', function(){
    //     alert('Overview Button Clicked');
    // });
    document.addEventListener('DOMContentLoaded', function(){
        
        // Button to tab mapping
        const tabMapping = {
            'btn_overview': 'overview-tab',
            'btn_admission': 'admission-tab',
            'btn_registration': 'registration-tab'
        };

        // Get all buttons
        const overviewBtn = document.getElementById('btn_overview');
        const admissionBtn = document.getElementById('btn_admission');
        const registrationBtn = document.getElementById('btn_registration');
        
        // Get all content areas
        const overviewTab = document.getElementById('overview-tab');
        const admissionTab = document.getElementById('admission-tab');
        const registrationTab = document.getElementById('registration-tab');

        // Overview button
        overviewBtn.addEventListener('click', function(){
            // Hide all
            overviewBtn.classList.remove('active');
            admissionBtn.classList.remove('active');
            registrationBtn.classList.remove('active');
            overviewTab.classList.add('d-none-custom');
            admissionTab.classList.add('d-none-custom');
            registrationTab.classList.add('d-none-custom');
            
            // Show overview
            overviewBtn.classList.add('active');
            overviewTab.classList.remove('d-none-custom');
        });

        // Admission button
        admissionBtn.addEventListener('click', function(){
            // Hide all
            overviewBtn.classList.remove('active');
            admissionBtn.classList.remove('active');
            registrationBtn.classList.remove('active');
            overviewTab.classList.add('d-none-custom');
            admissionTab.classList.add('d-none-custom');
            registrationTab.classList.add('d-none-custom');
            
            // Show admission
            admissionBtn.classList.add('active');
            admissionTab.classList.remove('d-none-custom');
        });

        // Registration button
        registrationBtn.addEventListener('click', function(){
            // Hide all
            overviewBtn.classList.remove('active');
            admissionBtn.classList.remove('active');
            registrationBtn.classList.remove('active');
            overviewTab.classList.add('d-none-custom');
            admissionTab.classList.add('d-none-custom');
            registrationTab.classList.add('d-none-custom');
            
            // Show registration
            registrationBtn.classList.add('active');
            registrationTab.classList.remove('d-none-custom');
        });

    });

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.v2.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/innovacomputersbd.com/resources/views/frontend/v2/asset/index.blade.php ENDPATH**/ ?>