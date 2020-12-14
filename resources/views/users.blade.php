@foreach($users as $user)
<tr>
	<td>{{$user->id}}</td>
	<td><button type="button" class="btn btn-default" aria-label="Left Align" data-toggle="modal" data-target="#EditModal"  data-username="{{$user->username}}" data-id="{{$user->id}}"><i class='fas fa-edit'></i></button> {{$user->username}}</td>
	<td>{{$user->name}}</td>
	<td>{{$user->email}}</td>
	<td>{{$user->age}}</td>
	<td><img {{($user->aboveAvg)? 'style=filter:grayscale(100%)' : ''}} height=50 width=50 src='{{url("personal_photos/")}}/{{$user->personal_photo}}'></td>
</tr>
@endforeach

