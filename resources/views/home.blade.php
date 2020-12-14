@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" />
    <style>
      .error {
        color: red;
      }
    </style>

@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
  

                    <!-- You are logged in! -->


                    <form method="POST" id="form" action="{{ route('new-person') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-6 mb-3">
                                <label for="email">E-mail</label>
                                <input type="email" name="email" class="form-control" id="email" placeholder="E-mail" required>
                                <div class="error fail-alert" id="emailError"></div>
                            </div>
                            <div class="form-group col-md-6 mb-3">
                                <label for="password">Password</label>
                                <input type="password" name="password" class="form-control" id="password" placeholder="" required>
                                <div class="error fail-alert" id="passwordError"></div>
                            </div>
                            
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6 mb-3">
                                <label for="name">Name</label>
                                <input type="text" name="name" class="form-control" id="name" placeholder="Name" value="" required>
                                <div class="error fail-alert" id="nameError"></div>
                            </div>
                            <div class="form-group col-md-4 mb-3">
                                <label for="username">Username</label>
                                <input name="username" type="text" class="form-control" id="username" placeholder="Username" required>
                                <div class="error fail-alert" id="usernameError"></div>
                            </div>

                            <div class="form-group col-md-2 mb-3">
                                <label for="age">Age</label>
                                <select name="age" id="age" class="custom-select" required>
                                  <option value="">Age</option>
                                  @for($i=10;$i<=85;$i++)
                                  <option value="{{$i}}">{{$i}}</option>
                                  @endfor
                                </select>
                                <div class="error fail-alert" id="ageError"></div>
                            </div>
                        </div>
                    
                        <div class="form-group">
                            <label for="biography">Biography</label>
                            <textarea name="biography" required class="form-control" id="biography" rows="3"></textarea>
                            <div class="error fail-alert" id="biographyError"></div>
                        </div>
                        <div class="form-group">
                            <div class="custom-file">
                                <label for="imgfile">Personal Photo</label>
                                <input accept="image/*" name="imgfile" type="file" class="form-control file-input" id="imgfile" required>
                                <div class="error fail-alert" id="imgfileError"></div>
                            </div>
                        </div>
                      <button class="btn btn-primary" type="submit">Submit form</button>
                    </form>


                    <br>
                    <hr>

                    
                    <h4>Users</h4>
                    <div class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Username</th>
                            <th scope="col">Name</th>
                            <th scope="col">E-mail</th>
                            <th scope="col">Age</th>
                            <th scope="col">Photo</th>
                          </tr>
                        </thead>
                        <tbody id="users-table">
                        </tbody>
                      </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="EditModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold">Edit username</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">
        <div class="md-form">
          <input type="text" id="edit-username" class="form-control validate">
          <input type="hidden" id="edit-id">
          <label class="error fail-alert" id="edit-label"></label>
        </div>
      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button id="save-edits" class="btn btn-default">Save</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.15.0/additional-methods.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
    <script type="text/javascript">
        $('#EditModal').on('show.bs.modal', function (event) {
          var button = $(event.relatedTarget);
          var username = button.data('username');
          var id = button.data('id');
          var modal = $(this);
          modal.find('.modal-body #edit-username').val(username);
          modal.find('.modal-body #edit-id').val(id);
        });
        $("#save-edits").on('click', function(){
            var username = $('#EditModal').find('.modal-body #edit-username').val();
            var id = $('#EditModal').find('.modal-body #edit-id').val()
            var url = "{{url('update-person/')}}"+'/'+id;
            var edited = $.ajax({
                statusCode: {
                    500: function() {
                    Swal.fire({
                      icon: 'error',
                      title: 'Oops...',
                      text: 'Something went wrong!'
                    });
                    }
                },
                url: url,
                type: "post",
                cache: false,
                data:{
                    _token:'{{ csrf_token() }}',
                    username: username
                },
                success: function(dataResult){
                    $('#EditModal').modal('toggle');
                    $('#edit-username').val("");
                    Swal.fire({
                      icon: 'success',
                      title: 'Data stored successfully! :D',
                      showConfirmButton: false,
                      timer: 1500
                    });
                    
                },
                error: function(response) {
                  $('#edit-label').text(response.responseJSON.username);
               }
            });
        });
            
    </script>
    <script>
        $(document).ready(function(){

            var request = function () {
            $.ajax({
                type: 'get',
                url: "{{ route('people') }}",
                success: function (data) {
                    $('#users-table').text(" ");
                    $('#users-table').append(data);
                }, 
                error: function (data) {
                    console.log(data);
                }
            });
            };
           setInterval(request, 2000);
        
            $("#form").submit(function(e) {
                e.preventDefault();
            }).validate({
                rules: {
                    username: {
                      required: true,
                      pattern: "([A-Za-z]+[0-9]|[0-9]+[A-Za-z])[A-Za-z0-9]*",
                      minlength: 8
                    },
                    name: {
                      required: true,
                      pattern: "^[a-zA-Z ]*$"
                    },
                    email: {
                      required: true,
                      email: true
                    },
                    biography: {
                      required: true,
                      minlength: 10
                    },
                    age: {
                      required: true,
                      number: true,
                      max: 85,
                      min: 10
                    },
                    imgfile: {
                      required: true,
                      accept: 'image/*'
                    },
                    password: {
                      required: true,
                      pattern: /[A-Z].*\d|\d.*[A-Z]/
                    },
                  },
                messages: {
                    username: {
                      required: 'Please enter username.',
                      pattern: 'Please enter a combination of letters and numbers.',
                      minlength: 'username must be at least 8 characters long.',
                    },
                    name: {
                      required: 'Please enter name.',
                      pattern: 'Please enter letters only.',
                    },
                    password: {
                      required: 'Please enter password.',
                      pattern: 'Password must contains a combination of letters and numbers with at least one Capital letter.',
                    },
                    email: {
                      required: 'Please enter Email Address.',
                      email: 'Please enter a valid Email Address.',
                    },
                    biography: {
                      required: 'Please enter biography.',
                      minlength: 'biography must be at least 10 characters long.',
                    },
                    imgfile: {
                      required: 'Please upload photo.',
                      accept: 'File must be an image file.',
                    }
                  },
                errorClass: "error fail-alert",
                validClass: "valid success-alert",
                submitHandler: function(form) { 
                    // alert("Do some stuff...");
                    var formData = new FormData($('#form')[0]);
                    $.ajax({
                        statusCode: {
                            500: function() {
                            Swal.fire({
                              icon: 'error',
                              title: 'Oops...',
                              text: 'Something went wrong!'
                            });
                            }
                        },
                        type: "POST",
                        url: "{{ route('new-person') }}",
                        data: formData, 
                        processData: false,
                        contentType: false,
                        cache: false,
                        
                        success: function(response)
                           {
                            console.log(response);
                            $('#form')[0].reset();
                            $('.error').text('');
                            Swal.fire({
                              icon: 'success',
                              title: 'Data stored successfully! :D',
                              showConfirmButton: false,
                              timer: 1500
                            });
                           },
                        error: function(response) {
                          $('#nameError').text(response.responseJSON.name);
                          $('#emailError').text(response.responseJSON.email);
                          $('#usernameError').text(response.responseJSON.username);
                          $('#passwordError').text(response.responseJSON.password);
                          $('#ageError').text(response.responseJSON.age);
                          $('#imgfileError').text(response.responseJSON.imgfile);
                          $('#biographyError').text(response.responseJSON.biography);
                       }
                        
                    });

                    return false;  
                }
            });
        });    
    </script>
@endsection
