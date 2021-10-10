<div class="col-12 text-center">
    @if ($users->avatar != '')
        <img src="storage/{{ USER_AVATAR_PATH . $users->avatar }}" alt="{{ $users->name }}" style="width: 30%;height:30%">
    @else
    <img src="images/{{ $users->gender == 1 ? 'male' : 'female'}}.png"  style="width: 60% ; height:60%">
    @endif
</div>
<div class="col-12">
    <div class="table-responsive">
        <table class="table table-borderless">
            <tr>
                <td></td><b>Name</b></td>
                <td><b>:</b></td>
                <td>{{ $users->name }}</td>
            </tr>
            <tr>
                <td><b>Email</b></td>
                <td><b>:</b></td>
                <td>{{ $users->email }}</td>
            </tr>
            <tr>
                <td><b>Mobile</b></td>
                <td><b>:</b></td>
                <td>{{ $users->mobile_no }}</td>
            </tr>
            <tr>
                <td><b>Role</b></td>
                <td><b>:</b></td>
                <td>{{ $users->role->role_name }}</td>
            </tr>
            <tr>
                <td><b>Gender</b></td>
                <td><b>:</b></td>
                <td>{{ GENDER[$users->gender] }} </td>
            </tr>
            <tr>
                <td><b>Status</b></td>
                <td><b>:</b></td>
                <td>{{ STATUS[$users->status] }}</td>
            </tr>
            <tr>
                <td><b>Created By</b></td>
                <td><b>:</b></td>
                <td>{{ $users->created_by }}</td>
            </tr>
            
            <tr></tr>
                <td><b>Joining Date</b></td>
                <td><b>:</b></td>
                <td>{{date('d M,Y',strtotime( $users->created_at ))}}</td>
            </tr>
            <tr>
                <td><b>Update Date</b></td>
                <td><b>:</b></td>
                <td>{{date('d M,Y',strtotime( $users->updated_at ))}}</td>
            </tr>
        </div>
    </div>
</div>
