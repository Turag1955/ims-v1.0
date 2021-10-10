<div class="col-md-12">
    <div class="table-responsive">
        <table class="table table-bordered">
            <tr>
                <td><b>Customer Group</b></td>
                <td><b>:</b></td>
                <td>{{ $result->customer_group->group_name }}</td>
            </tr>
            <tr>
                <td><b>Name</b></td>
                <td><b>:</b></td>
                <td>{{ $result->name }}</td>
            </tr>
            <tr>
                <td><b>Company Name</b></td>
                <td><b>:</b></td>
                <td>{{ $result->company_name }}</td>
            </tr>
            <tr>
                <td><b>Email</b></td>
                <td><b>:</b></td>
                <td>{{ $result->email }}</td>
            </tr>
            <tr>
                <td><b>Tax No.</b></td>
                <td><b>:</b></td>
                <td>{{ $result->tax_number }}</td>
            </tr>
            <tr>
                <td><b>City</b></td>
                <td><b>:</b></td>
                <td>{{ $result->city }}</td>
            </tr>
            <tr>
                <td><b>State</b></td>
                <td><b>:</b></td>
                <td>{{ $result->state }}</td>
            </tr>
            <tr>
                <td><b>Postal Code</b></td>
                <td><b>:</b></td>
                <td>{{ $result->postal_code }}</td>
            </tr>
            <tr>
                <td><b>Country</b></td>
                <td><b>:</b></td>
                <td>{{ $result->country }}</td>
            </tr>
            <tr>
                <td><b>Address</b></td>
                <td><b>:</b></td>
                <td>{{ $result->address }}</td>
            </tr>
            <tr>
                <td><b>Status</b></td>
                <td><b>:</b></td>
                <td>{{ $result->status == 1 ? 'Active':'Diabled' }}</td>
            </tr>
            <tr>
                <td><b>Created By</b></td>
                <td><b>:</b></td>
                <td>{{ $result->created_by }}</td>
            </tr>
            <tr>
                <td><b>Updated_by</b></td>
                <td><b>:</b></td>
                <td>{{ $result->updated_by }}</td>
            </tr>
            <tr>
                <td><b>Joining Date</b></td>
                <td><b>:</b></td>
                <td>{{ date('d M, Y',strtotime($result->created_at)) }}</td>
            </tr>
        </table>

        </table>
    </div>
</div>
