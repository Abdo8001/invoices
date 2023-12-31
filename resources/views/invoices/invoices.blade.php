@extends('layouts.master')
@section('title')
    قائمه الفواتير
@endsection
@section('css')
<!-- Internal Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
  <!--Internal   Notify -->
  <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قائمه الفواتير</span>
						</div>
					</div>
					<div class="d-flex my-xl-auto right-content">
						<div class="pr-1 mb-3 mb-xl-0">
							<button type="button" class="btn btn-info btn-icon ml-2"><i class="mdi mdi-filter-variant"></i></button>
						</div>
						<div class="pr-1 mb-3 mb-xl-0">
							<button type="button" class="btn btn-danger btn-icon ml-2"><i class="mdi mdi-star"></i></button>
						</div>
						<div class="pr-1 mb-3 mb-xl-0">
							<button type="button" class="btn btn-warning  btn-icon ml-2"><i class="mdi mdi-refresh"></i></button>
						</div>
						<div class="mb-3 mb-xl-0">
							<div class="btn-group dropdown">
								<button type="button" class="btn btn-primary">14 Aug 2019</button>
								<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" id="dropdownMenuDate" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<span class="sr-only">Toggle Dropdown</span>
								</button>
								<div class="dropdown-menu dropdown-menu-left" aria-labelledby="dropdownMenuDate" data-x-placement="bottom-end">
									<a class="dropdown-item" href="#">2015</a>
									<a class="dropdown-item" href="#">2016</a>
									<a class="dropdown-item" href="#">2017</a>
									<a class="dropdown-item" href="#">2018</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row opened -->
				<div class="row row-sm">
                    @if (session()->has('archive_invoice'))
                    <script>
                        window.onload = function() {
                            notif({
                                msg: "تم حذف الفاتورة بنجاح",
                                type: "success"
                            })
                        }

                    </script>
                @endif
				<!-- row opened -->
				<div class="row row-sm">
                    @if (session()->has('delete_invoice'))
                    <script>
                        window.onload = function() {
                            notif({
                                msg: "تم أرشفه الفاتورة بنجاح",
                                type: "success"
                            })
                        }

                    </script>
                @endif
                {{-- archive_success backup --}}
				<div class="row row-sm">
                    @if (session()->has('archive_success'))
                    <script>
                        window.onload = function() {
                            notif({
                                msg: "تم استعاده الفاتورة بنجاح",
                                type: "success"
                            })
                        }

                    </script>
                @endif

				<!-- row opened -->
				<div class="row row-sm">
                    @if (session()->has('update_status'))
                    <script>
                        window.onload = function() {
                            notif({
                                msg: "تم تحديث حاله الفاتورة بنجاح",
                                type: "success"
                            })
                        }

                    </script>
                @endif


                    @if (session()->has('edit'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>{{ session()->get('edit') }}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

					<!--div-->
					<div class="col-xl-12">
						<div class="card mg-b-20">
							<div class="card-header pb-0">
								<div class="d-flex ">
                                    @can('اضافة فاتورة')
                                    <a href="invoices/create" class="modal-effect btn btn-sm btn-primary" style="color:white"><i
                                            class="fas fa-plus fa-2x"></i>&nbsp; اضافة فاتورة</a>
                                            @endcan
                                            @can('تصدير EXCEL')
                                            <a href="{{ url('export/') }}" class="modal-effect btn btn-sm btn-success" style="color:white"><i
                                                class="fas fa-plus fa-2x"></i>&nbsp; تصدير EXCEL</a>
                                                @endcan
								</div>



							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table id="example1" class="table key-buttons text-md-nowrap">
										<thead>
											<tr>
                                                <th class="border-bottom-0">#</th>
                                                <th class="border-bottom-0">رقم الفاتورة</th>
                                                <th class="border-bottom-0">تاريخ القاتورة</th>
                                                <th class="border-bottom-0">تاريخ الاستحقاق</th>
                                                <th class="border-bottom-0">المنتج</th>
                                                <th class="border-bottom-0">القسم</th>
                                                <th class="border-bottom-0">الخصم</th>
                                                <th class="border-bottom-0">نسبة الضريبة</th>
                                                <th class="border-bottom-0">قيمة الضريبة</th>
                                                <th class="border-bottom-0">الاجمالي</th>
                                                <th class="border-bottom-0">الحالة</th>
                                                <th class="border-bottom-0">ملاحظات</th>
                                                <th class="border-bottom-0">العمليات</th>
											</tr>
										</thead>
										<tbody>
											@foreach ( $invoices as $invioce )
                                            <tr>
												<td>{{ $loop->index+1 }}</td>
                                                <td>{{ $invioce->invoice_number }} </td>
                                                <td>{{ $invioce->invoice_Date }}</td>
                                                <td>{{ $invioce->Due_date }}</td>
                                                <td>{{ $invioce->product }}</td>
                                                <td><a
                                                        href="{{ url('invoicesdeltails') }}/{{$invioce->id}}">{{ $invioce->section->section_name }}</a>
                                                </td>
                                                <td>{{ $invioce->Discount }}</td>
                                                <td>{{ $invioce->Rate_VAT }}</td>
                                                <td>{{ $invioce->Value_VAT }}</td>
                                                <td>{{ $invioce->Total }}</td>
                                                <td>
                                                    @if ($invioce->Value_Status == 1)
                                                        <span class="text-success">{{ $invioce->Status }}</span>
                                                    @elseif($invioce->Value_Status == 2)
                                                        <span class="text-danger">{{ $invioce->Status }}</span>
                                                    @else
                                                        <span class="text-warning">{{ $invioce->Status }}</span>
                                                    @endif
                                                    <td>{{ $invioce->note }}</td>
                                                    <td>

                                                            <div class="dropdown">
                                                                <button aria-expanded="false" aria-haspopup="true"
                                                                    class="btn ripple btn-primary btn-sm" data-toggle="dropdown"
                                                                    type="button">العمليات<i class="fas fa-caret-down ml-1"></i></button>
                                                                <div class="dropdown-menu tx-13">
                                                                    @can('تعديل الفاتورة')

                                                                        <a class="dropdown-item"
                                                                            href=" {{ url('edit_invoice') }}/{{ $invioce->id }}">تعديل
                                                                            الفاتورة</a>
                                                                            @endcan
                                                                            @can('حذف الفاتورة')



                                                                        <a class="dropdown-item" href="#" data-invoice_id="{{ $invioce->id }}"
                                                                            data-toggle="modal" data-target="#delete_invoice"><i
                                                                                class="text-danger fas fa-trash-alt"></i>&nbsp;&nbsp;حذف
                                                                            الفاتورة</a>
                                                                            @endcan
                                                                            @can('تغير حالة الدفع')
                                                                                 <a class="dropdown-item"
                                                            href="{{ URL::route('Status_show', [$invioce->id]) }}"><i
                                                                class=" text-success fas
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    fa-money-bill"></i>&nbsp;&nbsp;تغير
                                                            حالة
                                                            الدفع</a>
                                                            @endcan
                                                            @can('ارشفة الفاتورة')
                                                            <a class="dropdown-item" href="#" data-invoice_id="{{$invioce->id }}"
                                                                data-toggle="modal" data-target="#Transfer_invoice"><i
                                                                    class="text-warning fas fa-exchange-alt"></i>&nbsp;&nbsp;نقل الي
                                                                الارشيف</a>
                                                                @endcan
                                                                @can('طباعةالفاتورة')
                                                            <a class="dropdown-item" href="{{route('print_invoice',$invioce->id) }}"
                                                               ><i
                                                                    class="text-warning fas fa-exchange-alt"></i>&nbsp;&nbsp; طباعه الفاتوره
                                                                </a>
                                                                @endcan

                                                    </td>


											</tr>
                                            @endforeach

										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<!--/div-->
  <!-- حذف الفاتورة -->
    <div class="modal fade" id="delete_invoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">حذف الفاتورة</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <form action="{{ route('invoices.destroy', 'test') }}" method="post">
                        {{ method_field('delete') }}
                        {{ csrf_field() }}
                </div>
                <div class="modal-body">
                    هل انت متاكد من عملية الحذف ؟
                    <input type="hidden" name="invoice_id" id="invoice_id" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                    <button type="submit" class="btn btn-danger">تاكيد</button>
                </div>
                </form>
            </div>
        </div>
    </div>
     <!-- ارشيف الفاتورة -->
     <div class="modal fade" id="Transfer_invoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel">ارشفة الفاتورة</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
                 <form action="{{ route('invoices.destroy', 'test') }}" method="post">
                     {{ method_field('delete') }}
                     {{ csrf_field() }}
             </div>
             <div class="modal-body">
                 هل انت متاكد من عملية الارشفة ؟
                 <input type="hidden" name="invoice_id" id="invoice_id" value="">
                 <input type="hidden" name="id_page" id="id_page" value="2">

             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                 <button type="submit" class="btn btn-success">تاكيد</button>
             </div>
             </form>
         </div>
     </div>
 </div>

				</div>
				<!-- /row -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
		<!-- main-content closed -->
@endsection
@section('js')
<!-- Internal Data tables -->
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
<!--Internal  Datatable js -->
<script src="{{URL::asset('assets/js/table-data.js')}}"></script>
    <!--Internal  Notify js -->
    <script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>
    <script>
        $('#delete_invoice').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var invoice_id = button.data('invoice_id')
            var modal = $(this)
            modal.find('.modal-body #invoice_id').val(invoice_id);
        })

    </script>
    <script>
        $('#Transfer_invoice').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var invoice_id = button.data('invoice_id')
            var modal = $(this)
            modal.find('.modal-body #invoice_id').val(invoice_id);
        })

    </script>
@endsection
