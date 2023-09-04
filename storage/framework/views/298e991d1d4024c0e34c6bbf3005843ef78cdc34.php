<?php $__env->startSection("content"); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(()=>{
            $("#ploat_status").val('<?php echo e($propty_detail->booking_status); ?>');
            $("#payment_mode").val('<?php echo e($propty_detail->payment_mode); ?>');
            
        });   
</script>
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Scheme Form</h4>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" >
                    <label class="form-check-label" for="flexSwitchCheckDefault">For Hindi</label>
                </div>
                
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="offset-xl-2 col-xl-8">
            <div class="card">

                <div class="card-body">
                    <?php if(session('status')): ?>
                    <div class="alert alert-success">
                        <?php echo e(session('status')); ?>

                    </div>
                    <?php endif; ?>
                    <form class="needs-validation" method="post" action="<?php echo e(route('property.book_property')); ?>" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <input type="hidden" value="<?php echo e($property_data->property_id); ?>" name="property_id" />

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="schemeName">Associate Name</label>
                                    <input type="text" name="associate_name" value="<?php echo e(Auth::user()->name); ?>" readonly class="form-control" id="schemeName">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="schemeName">Associate Number</label>
                                    <input type="text" name="associate_number" value="<?php echo e(Auth::user()->mobile_number); ?>" readonly class="form-control" id="schemeName">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="schemeName">Associate Rera Number</label>
                                    <input type="text" name="associate_rera_number" value="<?php echo e(Auth::user()->associate_rera_number); ?>" readonly class="form-control" id="schemeName">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="schemeName">Customer Name <span class="text-danger">*</span></label>
                                     <input type="text" name="owner_name" class="form-control <?php $__errorArgs = ['owner_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="txtMessaged" id="owner_name" value="<?php echo e($propty_detail->owner_name); ?>" readonly>
                                    <input type="text" name="owner_name" class="form-control <?php $__errorArgs = ['owner_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="owner_named" value="<?php echo e($propty_detail->owner_name); ?>" readonly>
                                    <div id="newinput"></div>
                                    <?php $__errorArgs = ['owner_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="schemeName">Status</label>
                                    <select class="form-control" name="ploat_status" id="ploat_status" readonly>
                                        <option>Select Property Status</option>
                                        <option value="2">Book</option>
                                        <option value="3">Hold</option>
                                        <!--<option value="4">Cancel</option>-->

                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="schemeImg">Contact No <span class="text-danger">*</span></label>
                                    <input type="number" min="1" name="contact_no" value="<?php echo e($propty_detail->contact_no); ?>" class="form-control <?php $__errorArgs = ['contact_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="schemeImg" readonly>
                                    <?php $__errorArgs = ['contact_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="schemeImg">Address </label>
                                    <input type="text" name="address" value="<?php echo e($propty_detail->address); ?>" class="form-control <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="schemeImg" readonly>
                                    <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="schemeImg">Payment Mode</label>
                                    <select class="form-control" name="payment_mode" id="payment_mode" disabled>
                                        <option value="0">Select Payment Mode</option>
                                        <option value="1">RTGS/IMPS</option>
                                        <option value="2">Bank Transfer</option>
                                        <option value="3">Cheque</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="schemeImg">Adhar Card</label>
                                    <input type="file" name="adhar_card"  class="form-control" id="schemeImg" disabled>
                                    <?php if($propty_detail->adhar_card !=''): ?>
                                        <a href="<?php echo e(URL::to('/customer/aadhar',$propty_detail->adhar_card)); ?>" download target="_blank"><img src="<?php echo e(URL::to('/customer/aadhar',$propty_detail->adhar_card)); ?>" class="ms-2" style="height:25px;width:45px;"></a>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="schemeImg">Cheque Photo</label>
                                    <input type="file" name="cheque_photo" class="form-control" id="schemeImg" disabled>
                                    <?php if($propty_detail->cheque_photo !=''): ?>
                                        <a href="<?php echo e(URL::to('/customer/cheque',$propty_detail->cheque_photo)); ?>" download target="_blank"><img src="<?php echo e(URL::to('/customer/cheque',$propty_detail->cheque_photo)); ?>" class="ms-2" style="height:25px;width:45px;"></a>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="schemeImg">Attachment</label>
                                    <input type="file" name="attachement" class="form-control" id="schemeImg" disabled>
                                    <?php if($propty_detail->attachment !=''): ?>
                                        <a href="<?php echo e(URL::to('/customer/attach',$propty_detail->attachment)); ?>" download target="_blank"><img src="<?php echo e(URL::to('/customer/attach',$propty_detail->attachment)); ?>" class="ms-2" style="height:25px;width:45px;"></a>
                                    <?php endif; ?>                                
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="schemeImg">PAN Card Number</label>
                                    <input type="text" name="pan_card_no" value="<?php echo e($propty_detail->pan_card); ?>" class="form-control" id="schemeImg" readonly>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="schemeImg">PAN Card Photo</label>
                                    <input type="file" name="pan_card_image" class="form-control" id="schemeImg" disabled>
                                    <?php if($propty_detail->pan_card_image !=''): ?>
                                        <a href="<?php echo e(URL::to('/customer/pancard',$propty_detail->pan_card_image)); ?>" download target="_blank"><img src="<?php echo e(URL::to('/customer/pancard',$propty_detail->pan_card_image)); ?>" class="ms-2" style="height:25px;width:45px;"></a>
                                        
                                        <!-- <textarea name="txtMessage" id="txtMessaged"></textarea> -->
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php $loop_taxed_count=1; ?>
                            <?php $__currentLoopData = $multi_customer; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php 
                                $loop_count_prev=$loop_taxed_count;
                                $TarArr=(array)$val;
                                ?>

                                <script type="text/javascript">
                                    $(document).ready(()=>{
                                            $("#paymenmt_mode_<?php echo e($key); ?>").val('<?php echo e($TarArr['payment_mode']); ?>');
                                            
                                        });   
                                </script>
                                <div class="add_box_<?php echo e($loop_taxed_count++); ?>">
                                    <input id="piid" type="hidden" name="piid[]" value="">
                                    <div class="append-data mt-2"><h3 class="mb-2">Add Co-Applicant</h3>
                                        <div class="row"><div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="schemeName">Customer Name <span class="text-danger">*</span></label>
                                                <input type="text" name="owner_namelist[]" value ="<?php echo e($TarArr['owner_name']); ?>" class="form-control <?php $__errorArgs = ['owner_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="schemeName" readonly>
                                                    <?php $__errorArgs = ['owner_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                        <span class="invalid-feedback" role="alert"><strong><?php echo e($message); ?></strong></span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="schemeImg">Contact No <span class="text-danger">*</span></label>
                                                <input type="number" min="1" name="contact_nolist[]" value ="<?php echo e($TarArr['contact_no']); ?>" class="form-control <?php $__errorArgs = ['contact_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="schemeImg" readonly>
                                                    <?php $__errorArgs = ['contact_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                        <span class="invalid-feedback" role="alert"><strong><?php echo e($message); ?></strong></span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="schemeImg">Address </label>
                                                <input type="text" name="addresslist[]" value ="<?php echo e($TarArr['contact_no']); ?>" class="form-control <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="schemeImg" readonly>
                                                    <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                        <span class="invalid-feedback" role="alert"><strong><?php echo e($message); ?></strong></span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="schemeImg">Payment Mode</label>
                                                <select class="form-control" name="payment_modelist[]" id="paymenmt_mode_<?php echo e($key); ?>" disabled>
                                                    <option value="0">Select Payment Mode</option>
                                                    <option value="1">RTGS/IMPS</option>
                                                    <option value="2">Bank Transfer</option>
                                                    <option value="3">Cheque</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label" for="schemeImg">Adhar Card</label>
                                                <input type="file" name="adhar_cardlist[]" class="form-control" id="schemeImg" disabled>
                                                <?php if($TarArr['adhar_card'] !=''): ?>
                                                    <a href="<?php echo e(URL::to('/customer/aadhar',$TarArr['adhar_card'])); ?>" download target="_blank"><img src="<?php echo e(URL::to('/customer/aadhar',$TarArr['adhar_card'])); ?>" class="ms-2" style="height:25px;width:45px;"></a>
                                            
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label" for="schemeImg">Cheque Photo</label>
                                                <input type="file" name="cheque_photolist[]" class="form-control" id="schemeImg" disabled>
                                                <?php if($TarArr['cheque_photo'] !=''): ?>
                                                    <a href="<?php echo e(URL::to('/customer/cheque',$TarArr['cheque_photo'])); ?>" download target="_blank"><img src="<?php echo e(URL::to('/customer/cheque',$TarArr['cheque_photo'])); ?>" class="ms-2" style="height:25px;width:45px;"></a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label" for="schemeImg">Attachment</label>
                                                <input type="file" name="attachementlist[]" class="form-control" id="schemeImg" disabled>
                                                <?php if($TarArr['attachment'] !=''): ?>
                                                    <a href="<?php echo e(URL::to('/customer/attach',$TarArr['attachment'])); ?>" download target="_blank"><img src="<?php echo e(URL::to('/customer/attach',$TarArr['attachment'])); ?>" class="ms-2" style="height:25px;width:45px;"></a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="schemeImg">PAN Card Number</label>
                                                <input type="text" name="pan_card_nolist[]" value ="<?php echo e($TarArr['contact_no']); ?>" class="form-control" id="schemeImg" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="schemeImg">PAN Card Photo</label>
                                                <input type="file" name="pan_card_imagelist[]" class="form-control" id="schemeImg" disabled>
                                                <?php if($TarArr['pan_card_image'] !=''): ?>
                                                    <a href="<?php echo e(URL::to('/customer/pancard',$TarArr['pan_card_image'])); ?>" download target="_blank"><img src="<?php echo e(URL::to('/customer/pancard',$TarArr['pan_card_image'])); ?>" class="ms-2" style="height:25px;width:45px;"></a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <br/>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                             <!-- <div id="append-data-form"></div> -->
                             <!-- <div class="col-md-2">
                               <div class="form-group change"> -->
                                   <!--<label for="">&nbsp;</label><br/>-->
                                   <!-- <?php if($loop_taxed_count<2): ?>
                                   <a class="btn btn-success add-more mb-2" id="add-more" onclick="add_tax_more()" >+ Add More</a>
                                   <?php endif; ?>
                                </div>
                            </div>  -->

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label" for="schemeImg">Description</label>
                                   <input type="text" name="description" value="<?php echo e($propty_detail->description); ?>" class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> descriptiond"  id="txtMessage" id="description" readonly>                                    
                                    <input type="text" name="description"  value="<?php echo e($propty_detail->description); ?>" class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> description" id="descriptiond" readonly>
                                    
                                    <div id="newinput1"></div>
                                    <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>


                            <!-- end col -->
                        </div>

                        <div class="text-center"><button class="btn btn-primary" type="submit">Submit</button></div>
                    </form>
                </div>
            </div>
            <!-- end card -->
        </div> <!-- end col -->


    </div>
    <!-- end row -->

</div> <!-- container-fluid -->
<?php $__env->startPush('scripts'); ?>

<script>
$(function () {
        $('input[id="txtMessage"]').hide();
        $('input[id="txtMessaged"]').hide();

        //show it when the checkbox is clicked
        $('#flexSwitchCheckDefault').on('click', function () {
            if ($(this).prop('checked')) {
                $('input[id="txtMessage"]').fadeIn();
                $('input[id="txtMessaged"]').fadeIn();
                $('input[id="owner_named"]').remove();
                $('input[id="descriptiond"]').remove();
                
            } else {
                $('input[id="txtMessage"]').hide();
                $('input[id="txtMessaged"]').hide();
                newRowAdd1 ='<input type="text" name="description" class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> descriptiond"  id="txtMessage" id="description">'; 
                newRowAdd ='<input type="text" name="owner_name" class="form-control <?php $__errorArgs = ['owner_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="owner_named">'; 
            $('#newinput').append(newRowAdd);
            $('#newinput1').append(newRowAdd1);
            }
        });
    });
</script>
<script type="text/javascript">
        google.load("elements", "1", { packages: "transliteration" });
        var control;
        function onLoad() {         
            var options = {
                //Source Language
                sourceLanguage: google.elements.transliteration.LanguageCode.ENGLISH,
                // Destination language to Transliterate
                destinationLanguage: [google.elements.transliteration.LanguageCode.HINDI],
                shortcutKey: 'ctrl+g',
                transliterationEnabled: true
            };                     
            control = new google.elements.transliteration.TransliterationControl(options);  
            control.makeTransliteratable(['txtMessage','txtMessaged']);   
        }
        google.setOnLoadCallback(onLoad);         
</script>
<script>
   	// $("#add-more").on("click", function() {  
	// 		$("#append-data-form").append('<div class="append-data"><div class="row"><div class="col-md-6"><div class="mb-3"><label class="form-label" for="schemeName">Customer Name <span class="text-danger">*</span></label><input type="text" name="owner_name" class="form-control <?php $__errorArgs = ['owner_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="schemeName"><?php $__errorArgs = ['owner_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="invalid-feedback" role="alert"><strong><?php echo e($message); ?></strong></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div></div><div class="col-md-6"><div class="mb-3"><label class="form-label" for="schemeName">Status</label><select class="form-control" name="ploat_status"><option>Select Property Status</option><option value="2">Book</option><option value="3">Hold</option><!--<option value="4">Cancel</option>--></select></div></div><div class="col-md-6"><div class="mb-3"><label class="form-label" for="schemeImg">Contact No <span class="text-danger">*</span></label><input type="number" min="1" name="contact_no" class="form-control <?php $__errorArgs = ['contact_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="schemeImg"><?php $__errorArgs = ['contact_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="invalid-feedback" role="alert"><strong><?php echo e($message); ?></strong></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div></div><div class="col-md-6"><div class="mb-3"><label class="form-label" for="schemeImg">Address </label><input type="text" name="address" class="form-control <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="schemeImg"><?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="invalid-feedback" role="alert"><strong><?php echo e($message); ?></strong></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div></div><div class="col-md-6"><div class="mb-3"><label class="form-label" for="schemeImg">Payment Mode</label><select class="form-control" name="payment_mode"><option value="0">Select Payment Mode</option><option value="1">RTGS/IMPS</option><option value="2">Bank Transfer</option><option value="3">Cheque</option></select></div></div><div class="col-md-6"><div class="mb-3"><label class="form-label" for="schemeImg">Adhar Card</label><input type="file" name="adhar_card" class="form-control" id="schemeImg"></div></div><div class="col-md-6"><div class="mb-3"><label class="form-label" for="schemeImg">cheque Photo</label><input type="file" name="cheque_photo" class="form-control" id="schemeImg"></div></div><div class="col-md-6"><div class="mb-3"><label class="form-label" for="schemeImg">Attachment</label><input type="file" name="attachement" class="form-control" id="schemeImg"></div></div><div class="col-md-6"><div class="mb-3"><label class="form-label" for="schemeImg">PAN Card Number</label><input type="number" name="pan_card_no" class="form-control" id="schemeImg"></div></div><div class="col-md-6"><div class="mb-3"><label class="form-label" for="schemeImg">PAN Card Photo</label><input type="file" name="pan_card_image" class="form-control" id="schemeImg"></div></div><br/></div></div>');
			
   	    
   	// });  
   	
   	
		$("#removeEmail").on("click", function() {  
			$("#more-email").children().last().remove();  
		});  


        var loop_tax_count=1; 
        var loop_count=0; 
        var number=0;
   function add_tax_more(){
      // alert(loop_count);
    
      loop_tax_count++;
     
      // alert(loop_tax_count);
   
      if(loop_tax_count-loop_count<4){
      var html='<div class="add_box_'+loop_tax_count+'"><input id="piid" type="hidden" name="piid[]" value=""><div class="append-data mt-2"><h3 class="mb-2">Add Co-Applicant</h3><div class="row"><div class="col-md-6"><div class="mb-3"><label class="form-label" for="schemeName">Customer Name <span class="text-danger">*</span></label><input type="text" name="owner_namelist[]" class="form-control <?php $__errorArgs = ['owner_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="schemeName" required><?php $__errorArgs = ['owner_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="invalid-feedback" role="alert"><strong><?php echo e($message); ?></strong></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div></div><div class="col-md-6"><div class="mb-3"><label class="form-label" for="schemeImg">Contact No <span class="text-danger">*</span></label><input type="number" min="1" name="contact_nolist[]" class="form-control <?php $__errorArgs = ['contact_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="schemeImg"><?php $__errorArgs = ['contact_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="invalid-feedback" role="alert"><strong><?php echo e($message); ?></strong></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div></div><div class="col-md-6"><div class="mb-3"><label class="form-label" for="schemeImg">Address </label><input type="text" name="addresslist[]" class="form-control <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="schemeImg"><?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="invalid-feedback" role="alert"><strong><?php echo e($message); ?></strong></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div></div><div class="col-md-6"><div class="mb-3"><label class="form-label" for="schemeImg">Payment Mode</label><select class="form-control" name="payment_modelist[]"><option value="0">Select Payment Mode</option><option value="1">RTGS/IMPS</option><option value="2">Bank Transfer</option><option value="3">Cheque</option></select></div></div><div class="col-md-4"><div class="mb-3"><label class="form-label" for="schemeImg">Adhar Card</label><input type="file" name="adhar_cardlist[]" class="form-control" id="schemeImg"></div></div><div class="col-md-4"><div class="mb-3"><label class="form-label" for="schemeImg">Cheque Photo</label><input type="file" name="cheque_photolist[]" class="form-control" id="schemeImg"></div></div><div class="col-md-4"><div class="mb-3"><label class="form-label" for="schemeImg">Attachment</label><input type="file" name="attachementlist[]" class="form-control" id="schemeImg"></div></div><div class="col-md-6"><div class="mb-3"><label class="form-label" for="schemeImg">PAN Card Number</label><input type="text" name="pan_card_nolist[]" class="form-control" id="schemeImg"></div></div><div class="col-md-6"><div class="mb-3"><label class="form-label" for="schemeImg">PAN Card Photo</label><input type="file" name="pan_card_imagelist[]" class="form-control" id="schemeImg"></div></div><br/></div></div>';
            html+='<div class="col-md-2"><div class="row mb-3 ms-1 property_tax_'+loop_tax_count+'""><button type="button" class="btn btn-danger mt-2" style="width:auto;" onclick=remove_tax_more("'+loop_tax_count+'")><i class="fa fa-minus"></i>&nbsp; Remove</button></div></div></div>'; 
        }else{
            var html='';
            loop_tax_count--;
        }  
      
       
       jQuery('#append-data-form').append(html)
   }
   function remove_tax_more(loop_tax_count){
        jQuery('.add_box_'+loop_tax_count).remove();
             loop_count++;
   }
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("dashboard.master", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\gksm\resources\views/scheme/edit-book-hold-property.blade.php ENDPATH**/ ?>