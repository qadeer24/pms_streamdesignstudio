@extends('layouts.main')
@section('title','People')
@section('content')
    @include( '../sweet_script')
    <style type="text/css">
    .lightbox{
      z-index: 1041;
    }
    .small-img{
      width: 100px;height: 100px;
    }
  </style>
    
    <div class="page-inner">
        <h4 class="page-title">@yield('title') Profile</h4>
        <div class="row row-card-no-pd">
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5">
                                <div class="icon-big text-center">
                                    <i class="fas fa-car text-success" style="font-size:2.4rem"></i>
                                </div>
                            </div>
                            <div class="col col-stats">
                                <div class="numbers">
                                    <p class="card-category">
                                        @if((isset($schedules))  && ($schedules > 0) )
                                            <a href="{{ url('peoples')}}/shdls/{{$data->id}}"> Schedules</a>
                                        @else
                                            Schedules
                                        @endif
                                    </p>
                                    <h4 class="card-title">{{ isset($schedules) ? ($schedules) : 0}} </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5">
                                <div class="icon-big text-center">
                                    <i class="fas fa-coins text-primary" style="font-size:2.4rem"></i>
                                </div>
                            </div>
                            <div class="col col-stats">
                                <div class="numbers">
                                    <p class="card-category">
                                        @if((isset($bookings))  && ($bookings > 0) )
                                            <a href="{{ url('peoples')}}/bkngs/{{$data->id}}"> Bookings</a>
                                        @else
                                            Bookings
                                        @endif
                                    </p>
                                    <h4 class="card-title"> {{ isset($bookings) ? ($bookings) : 0}}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5">
                                <div class="icon-big text-center">
                                    <i class="fas fa-envelope text-danger" style="font-size:2.4rem"></i>
                                </div>
                            </div>
                            <div class="col col-stats">
                                <div class="numbers">
                                    <p class="card-category">
                                        @if((isset($complaints))  && ($complaints > 0) )
                                            <a href="{{ url('peoples')}}/cmplnts/{{$data->id}}"> Complaints</a>
                                        @else
                                            Complaints
                                        @endif
                                    <h4 class="card-title"> {{ isset($complaints) ? ($complaints) : 0}}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5">
                                <div class="icon-big text-center">
                                    <i class="fas fa-star text-warning" style="font-size:2.4rem"></i>
                                </div>
                            </div>
                            <div class="col col-stats">
                                <div class="numbers">
                                    <p class="card-category"></p>
                                    <p class="card-category">
                                        @if((isset($ratings))  && ($ratings > 0) )
                                            <a href="{{ url('peoples')}}/rtngs/{{$data->id}}"> Captain Rating</a>
                                        @else
                                            Captain Rating
                                        @endif
                                    </p>
                                    <h4 class="card-title"> {{ isset($ratings) ? ($ratings) : 0}} </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

       
        <div class="row">
           
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">@yield('title') </h4>
                            <span class="ml-auto">
                                @if((isset($data->active)) && ( ($data->active == 1) || ($data->active == "Active") ) )
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-danger">Inactive</span>
                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div class="table-responsive">
                                    <table class="table dt-responsive">
                                        <tr>
                                            <th width="40%">People</th>
                                            <td>{{$data->fname}}</td>
                                        </tr>
                                        <tr>
                                            <th>Age</th>
                                            <td>{{ isset($detail->age) ? ($detail->age) . " years old"   :""}}</td>
                                        </tr>

                                        
                                        <tr>
                                            <th width="50%">CNIC</th>
                                            <td>{{ isset($detail->cnic) ? ($detail->cnic) :""}}</td>
                                        </tr>
                                        <tr>
                                            <th>Contact No</th>
                                            <td>{{ isset($detail->cnic) ? ($detail->contact_no) :""}} </td>
                                        </tr>
                                        
                                       
                                        <tr>
                                            <th>Address</th>
                                            <td>{{ isset($detail->cnic) ? ($detail->address) :""}}</td>
                                        </tr>
                                        <br>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">@yield('title') Vehicle</h4>
                           
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div class="table-responsive">
                                    <table class="table dt-responsive">
                                        <tr>
                                            <th width="50%">Vehicle</th>
                                            <td>
                                                @if(isset($detail->manufacturer))
                                                    {{$detail->manufacturer}}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Model#</th>
                                            <td>
                                                @if(isset($detail->modal))
                                                    {{$detail->modal}}
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Vehicle#</th>
                                            <td>
                                                @if(isset($detail->vehicle_no))
                                                    {{$detail->vehicle_no}}
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Color</th>
                                            <td>
                                                @if(isset($detail->color))
                                                    {{$detail->color}}
                                                @endif
                                            </td>
                                        </tr>


                                        <tr>
                                            <th>Seats</th>
                                            <td>
                                                @if(isset($detail->seat))
                                                    {{$detail->seat}}
                                                @endif
                                            </td>
                                        </tr>

                                        
                                        <!-- <tr>
                                            <th>AC</th>
                                            <td>
                                                @if(isset($data->model_no))
                                                    @if($data->ac == 0 )
                                                        <i class="fas fa-times-circle" style="color:red;font-size:24px"></i>
                                                    @else
                                                        <i class="fas fa-check-circle" style="color:#4AD24E;font-size:24px"></i>
                                                    @endif 
                                                @endif
                                            </td>
                                        </tr> -->
                                        
                                        <br>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-profile card-secondary">
                    <div class="card-header" style="background-image: url('../assets/img/blogpost.jpg')">
                        <div class="profile-picture">
                            <div class="avatar avatar-xl">
                                @if(isset($detail->profile_pic))
                                    <img src="{{ asset('/uploads/peoples/'.$detail->profile_pic) }}" alt="..." class="avatar-img rounded-circle"  style="width:80px; height:80px">
                                @else
                                    <img src="{{ asset('/uploads/no_image.png') }}" alt="..." class="avatar-img rounded-circle" style="width:80px; height:80px">
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="user-profile text-center">
                            <div class="name">
                                {{ucwords($data->fname)}} 
                                @if(isset($detail->verified) && $detail->verified == 0 )
                                    <i class="fas fa-times-circle" style="color:red;font-size:24px" data-toggle="tooltip" data-placement="top" title="Non-verified Profile"></i>
                                @else
                                    <i class="fas fa-check-circle" style="color:#4AD24E;font-size:24px" data-toggle="tooltip" data-placement="top" title="Verified Profile"></i>
                                @endif 
                            </div>
                            <div class="name"><b>{{($data->type)}}</b></div>
                            <div class="job">{{  isset($detail->email) ? ($detail->email) : "" }}</div>
                            <div class="job">{{(isset($detail->username) ? ($detail->username) : "")}}</div>
                          
                            
                            <!-- <div class="desc">A man who hates loneliness</div> -->
                            <div class="social-media">
                                <a class="btn btn-info btn-twitter btn-sm btn-link" href="#"> 
                                    <span class="btn-label just-icon"><i class="flaticon-twitter"></i> </span>
                                </a>
                                <a class="btn btn-danger btn-sm btn-link" rel="publisher" href="#"> 
                                    <span class="btn-label just-icon"><i class="flaticon-google-plus"></i> </span> 
                                </a>
                                <a class="btn btn-primary btn-sm btn-link" rel="publisher" href="#"> 
                                    <span class="btn-label just-icon"><i class="flaticon-facebook"></i> </span> 
                                </a>
                                <a class="btn btn-danger btn-sm btn-link" rel="publisher" href="#"> 
                                    <span class="btn-label just-icon"><i class="flaticon-dribbble"></i> </span> 
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           
        </div>
    </div>

    <script>
        $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
        </script>
  
@endsection
