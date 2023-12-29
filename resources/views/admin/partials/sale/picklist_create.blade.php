@extends('layouts.admin')
@section('content')
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close"
                data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{!! session()->get('message') !!}
        </div>
    @endif
    @if (session()->has('not_permitted'))
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert"
                aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}
        </div>
    @endif

    <section>
        <?php $cid = $id;
        ?>
        <!-- Page Header -->
        <ol class="breadcrumb">
            {{-- <div class="flip pull-left">
        <h1 class="h2 page-title"><?php //echo $page_title; ?></h1>
        <div class="text-muted page-desc"><?php //echo $page_subheading; ?></div>
    </div> --}}

        </ol>
        <div class="container-fluid">




            <section class="container-right1" style="width:100%;left:0">
                <div class="container-fluid" style="position: relative;">
                    <div class="row">
                        <div class="col-md-12">
                            <div style="float:right !important">
                                <ul class="" style="display: flex;list-style: none">
                                    <li style="padding-right: 20px">
                                        <button name="save_picklist" type="submit" id='save_data' class="btn btn-primary ">

                                            Save Picklist
                                        </button>
                                    </li>
                                    <li>
                                        <!-- <a href="?order_id=INV-0010&void_list" class="reset-anchor">
    <center><img src="../images/vs-ico2.png" style="width:20px;height: 20px;"></center>
    <p style="font-size:12px;">Void Sale</p>
    </a> -->
                                    </li>
                                </ul>
                            </div>
                            <h3 class="no-margin">New Picklist</h3>
                            <p class="no-margin" style="color:grey;font-size:14px">Create Picklist based on order</p>
                        </div>
                        <div class="col-md-12">
                            <hr class="no-margin">
                        </div>
                    </div>
                    <div class="row m-t-20">
                        <div class="col-md-5 border-right">
                            <p style="font-size:14px;" class="no-margin"><b><u>Sale Details:</u></b></p>
                            <div style="font-size:14px;margin-top:12px">
                                <label style="width:100px;"><b>Sale Id </b></label> : &nbsp;
                                <input style="width:300px" id="invoice_number" type="" value="<?php echo $cid; ?>"
                                    readonly="" name="" required="">
                            </div>
                            <div style="font-size:14px;">
                                <label style="width:100px;"><b>Bill To </b></label> : &nbsp;
                                <input style="width:300px" type="" value="{{ $sale[0]['branch']['name'] }}" name="" required=""
                                    id="user_name" readonly="">

                                <input style="width:300px" type="hidden" value="" id="user_id" name="">
                            </div>
                            <div style="font-size:14px;">
                                <label style="width:100px;"><b>Address </b></label> : &nbsp;
                                <input style="width:300px" type="" value="" name=""
                                    style="background-color: #d3d3d3 !important;" required="" readonly="">
                            </div>
                            <div class="m-t-20">
                                <table class="table" id="table_main">
                                    <thead>



                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Item Description</th>
                                            <th scope="col">Picking Qty</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                     <?php
                                         $q=0;
                                         foreach ($sale_product as $key => $items) {
                                        ?>
                                    <?php
                                     $quan_fnal = $items->qty - $items->pic_qty ;
                                    
                                     if ($quan_fnal != 0) {
                                    ?>
                                <tr>
                                    <th scope="row"><?php echo $key + 1;
                                    ?></th>
                                    <td><?php echo $items->product->name;
                                    ?><input type="hidden" name=""
                                            value="<?php echo $items->product->name;
                                            ?>" id="<?php echo 'name_' . $items->product->id;
                                            ?>">
                                    </td>

                                    <td><div class="<?php echo 'c_q_' . $items->product->id;
                                    ?>"><?php echo $quan_fnal;
                                    ?></div><input type="hidden" name=""
                                            value="<?php echo $quan_fnal;
                                            ?>"
                                            id="<?php echo 'quantity_' . $items->product->id;
                                            ?>">
                                    </td>
                                    <td><input type="number" name="" required style="width:38px"
                                            id="<?php echo 'picked_q_' . $items->product->id;
                                            ?>">
                                        <button type="button" id="<?php echo $items->product->id;
                                        ?>"
                                            class=" add_new btn btn-primary">Add Picklist</button>
                                    </td>
                                </tr>

                                <?php }}
                                ?> 

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="row">

                                <p style="font-size:14px;" class="no-margin"><b><u>Picklist Details: <div class="change">
                                            </div></u></b></p><br />
                                
                                <div style="font-size:14px;margin-top:40px;margin-left: -106px;">
                                    <label style="width:100px;"><b>Ref. No</b></label> : &nbsp;
                                    <input style="width:300px" type="" id="ref_no" value="{{ $sale[0]['reference_no']}}"
                                        name="" required="" readonly>
                                </div>
                                <div style="font-size:14px;">
                                    <label style="width:100px;"><b>Picked By</b></label> : &nbsp;
                                    <input style="width:300px" type="" id="picked_by" value=""
                                        name="picked_by" required="">
                                </div>
                                <div style="font-size:14px;">
                                    <label style="width:100px;"><b>Pickup date</b></label> : &nbsp;
                                    <input style="width:300px" type="date" id="pick_date"
                                        value="<?php echo date('Y-m-d');
                                        ?>" name="pickup_date" required="">
                                </div>
                            </div>

                            <div class="row m-t-20">
                                <div class="col-md-12">
                                    <table class="table" id="maintable">
                                        <thead>
                                            <tr>

                                                <th scope="col">Item Description</th>
                                                <th scope="col">Picking Qty</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr id="rows">

                                            </tr>
                                        </tbody>
                                    </table>
                                    <br>

                                </div>
                            </div>

                        </div>

                    </div>
                </div>
        </div>
        </div>
    @endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript">
        // $(document).ready(function() {
        //     $('#item-list').DataTable({
        //         "ajax": {
        //           //  url: SITE_URL + '/items/get_items_assigned/' + <?php echo $id; ?>,
        //             data: {
        //                 segment_uri: <?php echo $id; ?>
        //             },
        //             type: 'GET'
        //         },
        //     });
        // });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {

            // $(".myBtn").click(function(){
            //      $('.myModal1').modal('show');
            // });

            // $("#items_table").on(".myBtn", "click", function(){

            //     $('.myModal1').modal('show');
            // });

            $("#items_table").on("click", ".myBtn", function() {
                var c_id = <?php echo $cid; ?>;
                //alert(this.id);
                $("#client_id").val(c_id);
                $("#item_id").val(this.id);
                $("#item_name").val(this.name);
                //alert(c_id);
                $('.myModal1').modal('show');
            });
            //});

            $(document).ready(function() {
                //$('#pick_date').val(new Date().toDateInputValue());
                $(".add_new").click(function() {

                    var item_id = this.id;
                    //alert(item_id);
                    var item_name = $('#name_' + item_id).val();
                    //alert(item_name);
                    var item_quantity = $('#quantity_' + item_id).val();
                    var item_quantity_p = $('#picked_q_' + item_id).val();
                    //alert(item_name);
                    if (item_quantity_p > item_quantity  ) {

                        alert("Please Select Quantity Properly");
                    } else if (item_quantity == 0) {
                        alert("All Items Picked");
                    } else if (item_quantity_p <= 0) {
                        alert("Negative Quantity Not Allowed");
                    } else {




                        var remain_q = item_quantity - item_quantity_p;

                        $('.c_q_' + item_id).html(remain_q);
                        //$('.change').html('sdsdsd');
                        $('#quantity_' + item_id).val(remain_q);


                        $("#maintable").each(function() {

                            var tds = '<tr id="delete_' + item_id + '"><td>' + item_name +
                                '<input type="hidden" name="item_name" value="' +
                                item_name +
                                '"><input type="hidden" name="item_id" value="' + item_id +
                                '"><input type="hidden" name="item_q" value="' +
                                item_quantity_p + '"></td><td>' + item_quantity_p +
                                '</td><td><button type="button"value="' + item_id +
                                '"class="delete_item btn btn-outline-danger"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16"><path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/><path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/></svg></button></td>';
                            // jQuery.each($('tr:last td', this), function () {
                            //     tds += '<td>' + $(this).html() + '</td>';
                            // });
                            tds += '</tr>';
                            if ($('tbody', this).length > 0) {
                                $('tbody', this).append(tds);
                            } else {
                                $(this).append(tds);
                            }
                        });


                    }

                });


                $("#maintable").on('click', '.delete_item', function() {
                    //$(this).parent().parent().remove();
                    var item_id = this.value;

                    $('#delete_' + item_id).remove();


                });

                // $(".delete_item").click(function() {

                //     //var item_id = this.val;
                // alert(12);
                //     //alert(item_id);


                // });

                $("#save_data").click(function() {
                    //alert('ok');
                    var item_id = [];
                    $(":input[name='item_id']").each(function(index, element) {
                        item_id.push($(this).val());
                    });

                    var item_name = [];
                    $(":input[name='item_name']").each(function(index, element) {
                        item_name.push($(this).val());
                    });
                    // $("#picked_by").prop('required',true);

                    var item_q = [];
                    $(":input[name='item_q']").each(function(index, element) {
                        item_q.push($(this).val());
                    });
                    var invoice_number = $('#invoice_number').val();

                    var user_name = $('#user_name').val();
                    var user_id = $('#user_id').val();
                    var ref_no = $('#ref_no').val();
                    var picked_by = $('#picked_by').val();
                    var pick_date = $('#pick_date').val();
                    if (item_id == false) {
                        alert('Please Select First Items then Submit');
                    } else if (picked_by == false) {
                        alert('Picked By Name Is Required');
                    } else {

                        $.ajax({
                            url: "{{route('admin.sale.picklist.save')}}",
                            type: 'POST',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                item_id: item_id,
                                item_name: item_name,
                                item_q: item_q,
                                user_name: user_name,
                                invoice_number: invoice_number,
                                user_id: user_id,
                                ref_no: ref_no,
                                picked_by: picked_by,
                                pick_date: pick_date
                            },

                            success: function(response) {
                                //$("#loader").hide();
                                window.location.href = "{{route('admin.sale.picklist',"$cid")}}" ;
                            },
                            error: function() {
                                //$("#loader").show();
                                alert("error occured");
                            }
                        });

                    }
                    //console.log(item_name,item_id,item_q);

                });




            });
        });
    </script>
