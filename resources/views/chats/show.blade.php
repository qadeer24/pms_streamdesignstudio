@extends('layouts.main')
@section('title','Chats / Messages')
@section('content')
    @include( '../sweet_script')

    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">@yield('title')</h4>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Show @yield('title')</h4>
                            <a  href="{{ route('chats.index') }}" class="btn btn-primary btn-xs ml-auto">
                                <i class="fas fa-arrow-left"></i>
                            </a>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-12">
                                <div class="table-responsive">
                                    <table class="table dt-responsive">
                                        <tbody>
                                            <tr>
                                                <td width="30%">Sender</td>
                                                <td>{{ (isset($data->sender->fname)) ?  $data->sender->fname : "" }}</td>
                                            </tr>
                                            <tr>
                                                <td>Receiver</td>
                                                <td>{{  (isset($data->receiver->fname)) ?  $data->receiver->fname : "" }}</td>
                                            </tr>
                                             
                                            
                                            <tr>
                                                <td>Message</td>
                                                <td>{{ (isset($data->message)) ?  $data->message : "" }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

@endsection
