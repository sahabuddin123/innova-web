@extends('admin.app')

@section('title')
@endsection

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4 print_none">
        <div class="print_none">
            <h1 class="h3 mb-0 text-gray-800"><i class="fa fa-user"></i> </h1>
        </div>
        <div class="print_none">
        </div>
    </div>
    @include('admin.partials.flash')

    <div class="container bootdey">
        <div class="tile">
            <div class="tile-body">

                <div class="row invoice row-printable">
                    <div class="col-md-12">
                        <!-- col-lg-12 start here -->
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Category Name</th>
                                    <th>Total Expense</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($result as $category)
                                    <tr>
                                        <td>{{ $category['category_name'] }}</td>
                                        <td>{{ $category['total_amount'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                               
                            </tfoot>
                        </table>

                        <!-- col-lg-12 end here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

