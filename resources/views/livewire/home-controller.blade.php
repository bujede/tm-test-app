<div class="row">
    <div class="col-md-8 offset-md-2 col-sm-12 ">
        <hr>
        <h1 class="text-center">
            Hello {{ $user->name }}!
            <button class="btn btn-danger float-end" wire:click="makeSocialLogOut" type="button">Sign Out</button>
        </h1>
        <hr>
        <form class="row" wire:submit.prevent="getStockDetails">
            <div class="col-md-4 col-sm-12">
                <div class="form-group">
                    <label for="">Enter your stock symbol</label>
                    <select wire:model.defer="symbol" class="form-control" required>
                        <option value="">Select</option>
                        <option value="AMZN">Amazon</option>
                        <option value="GOOGL">Google</option>
                        <option value="BGNE">Beigene Ltd</option>
                    </select>
                    <br>
                    <button type="submit" class="btn btn-info">Get Details</button>                   
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-8 offset-md-2 col-sm-12">
        <br><br>
        <div class="card">
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Symbol</th>
                            <th>Price</th>
                            <th>High</th>
                            <th>Low</th>
                            <th>Date & Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ( $data as $row )
                            <tr>
                                <td>{{ $row->symbol }}</td>
                                <td>{{ $row->price }}</td>
                                <td>{{ $row->high }}</td>
                                <td>{{ $row->low }}</td>
                                <td>{{ date("h:i A d M y", strtotime($row->created_at)) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <br>
                <button class="btn btn-danger" type="button" wire:click="flushDataAndRecreateTable">Remove Date & Recreate Table</button>
            </div>
        </div>
    </div>
    <div class="col-md-8 offset-md-2 col-sm-12">
        <div class="form-group">
            Other Actions:
            <br>
            <button class="btn btn-info" type="button" wire:click="runMigration">Re-Run Migration</button>
        </div>
    </div>
</div>