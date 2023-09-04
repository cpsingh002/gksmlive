<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" data-key="t-menu">Menu</li>

                <li>
                    <a href="<?php echo e(URL::to('/')); ?>">

                        <!--<i data-feather="home"></i>-->
                        <i class="fa-solid fa-house"></i>
                        <span data-key="t-dashboard">Dashboard</span>
                    </a>
                </li>
                <?php if(Auth::user()->user_type == 1): ?>
                <li>
                    <a href="<?php echo e(URL::to('/productions')); ?>">
                        <!--<i data-feather="grid"></i>-->
                        <i class="fa-solid fa-building"></i>
                        <span data-key="t-apps">Production</span>
                    </a>
                </li>
                <?php endif; ?>


                <?php if(Auth::user()->user_type == 1): ?>
                <li>
                    <a href="<?php echo e(URL::to('/attributes')); ?>">
                        <!--<i data-feather="grid"></i>-->
                        <i class="fa-solid fa-braille"></i>
                        <span data-key="t-apps">Attributes</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(URL::to('admin/opertor')); ?>">
                        <!--<i data-feather="grid"></i>-->
                        <i class="fa-solid fa-braille"></i>
                        <span data-key="t-apps">Operators</span>
                    </a>
                </li>
                 <li>
                    <a href="<?php echo e(URL::to('/teams')); ?>">
                        <!--<i data-feather="grid"></i>-->
                        <i class="fa-solid fa-users"></i>
                        <span data-key="t-apps">Teams</span>
                    </a>
                </li>
                <?php endif; ?>
              
                <?php if(Auth::user()->user_type == 2): ?>
                <li class="menu-title" data-key="t-menu">User</li>
                <li>
                    <a href="<?php echo e(URL::to('/operators')); ?>">
                        <!--<i data-feather="grid"></i>-->
                        <i class="fa-solid fa-user"></i>
                        <span data-key="t-apps">Operators</span>
                    </a>

                </li>
                <?php endif; ?>

                <li>
                    <?php if(Auth::user()->user_type == 1): ?> 
                        <a href="<?php echo e(URL::to('admin/schemes')); ?>">
                    <?php elseif(Auth::user()->user_type == 2): ?> 
                        <a href="<?php echo e(URL::to('production/schemes')); ?>">
                     <?php elseif(Auth::user()->user_type == 3): ?> 
                        <a href="<?php echo e(URL::to('opertor/schemes')); ?>">
                     <?php elseif(Auth::user()->user_type == 4): ?> 
                        <a href="<?php echo e(URL::to('associate/schemes')); ?>">
                    <?php endif; ?>
                    
                        <!--<i data-feather="grid"></i>-->
                        <i class="fa-solid fa-s"></i>
                        <span data-key="t-apps">Schemes</span>
                    </a>

                </li>

                <!-- <li>
                    <a href="<?php echo e(URL::to('/properties')); ?>">
                        <i data-feather="grid"></i>
                        <span data-key="t-apps">Property</span>
                    </a>

                </li> -->

                <?php if(Auth::user()->user_type == 1): ?>
                <li>
                    <a href="<?php echo e(URL::to('/associates')); ?>">
                        <!--<i data-feather="grid"></i>-->
                        <i class="fa-solid fa-users"></i>
                        <span data-key="t-apps">Associate</span>
                    </a>

                </li>
                <?php endif; ?>

                <?php if(Auth::user()->user_type == 1): ?>
                <li>
                    <a href="<?php echo e(URL::to('/associate-pending-request')); ?>">
                        <!--<i data-feather="grid"></i>-->
                        <i class="fa-solid fa-user-group"></i>
                        <span data-key="t-apps">Associate Request</span>
                    </a>

                </li>
                <?php endif; ?>
               
                <li>
                    <a href="<?php echo e(URL::to('/property-reports')); ?>">
                        <!--<i data-feather="grid"></i>-->
                        <i class="fa-solid fa-file-arrow-up"></i>
                        <span data-key="t-apps">Book/Hold Reports</span>
                    </a>

                </li>
                
                <?php if(Auth::user()->user_type == 1 || Auth::user()->user_type == 4): ?>
                <li class="menu-title" data-key="t-menu">Associate Reports</li>
                <li>
                    <a href="<?php echo e(URL::to('/associate-property-reports')); ?>">
                        <!--<i data-feather="grid"></i>-->
                        <i class="fa-solid fa-file-arrow-up"></i>
                        <span data-key="t-apps">Book/Hold Reports</span>
                    </a>

                </li>
                <?php endif; ?>
                <?php if(Auth::user()->user_type == 1 || Auth::user()->user_type == 2 || Auth::user()->user_type == 3): ?>
                <li class="menu-title" data-key="t-menu">CSV</li>
                <li>
                    
                    <?php if(Auth::user()->user_type == 1): ?> 
                        <a href="<?php echo e(URL::to('admin/import-csv')); ?>">
                    <?php elseif(Auth::user()->user_type == 2): ?> 
                        <a href="<?php echo e(URL::to('production/import-csv')); ?>">
                     <?php elseif(Auth::user()->user_type == 3): ?> 
                        <a href="<?php echo e(URL::to('opertor/schemes')); ?>">
                     
                    <?php endif; ?>
                        <!--<i data-feather="grid"></i>-->
                        <i class="fa-solid fa-file-csv"></i>
                        <span data-key="t-apps">Import CSV</span>
                    </a>

                </li>
                <?php endif; ?>
            

                

            </ul>


        </div>
        <!-- Sidebar -->
    </div>
</div><?php /**PATH C:\xampp\htdocs\gksm\resources\views/dashboard/left_bar.blade.php ENDPATH**/ ?>