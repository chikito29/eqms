<div class="panel panel-default">
    <div class="panel-heading" style="background-color: #95b75d;">
        <h3 class="panel-title"><strong>Filter/Search CPARS</strong></h3>
        <ul class="panel-controls">
            <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
        </ul>                                
    </div>
    <div class="panel-body">
        <form class="form-horizontal" action="{{ route('cpars.index') }}" method="get">
            <div class="radio">
                <label>
                    <input type="radio" name="search-type" id="quick" checked>Do quick search by: CPAR#, Branch, Department, Severity or the year it was created. **One keyword per search only**
                </label>
            </div>
            <div class="form-group col-md-5" id="normal-search">
                <input type="text" name="search" id="search" class="form-control" placeholder="To fetch all cpars, leave this field empty then click submit">
            </div>
            <div class="radio">
                <label>
                    <input type="radio" name="search-type" id="detailed"> Or accurately here
                </label>
            </div>
            <div id="detailed-search">
                <div class="form-group col-md-5">
                <label>Audit type</label>
                <select name="audit_type" class="form-control select">
                    <option value="">Empty selection</option>
                    <option value="dnv">DNV</option>
                    <option value="internal">Internal</option>
                    <option value="marina">Marina</option>
                </select>
                </div>
                <div class="form-group col-md-5">
                    <label>Severity</label>
                    <select name="severity" class="form-control select">
                        <option value="">Empty selection</option>
                        <option value="observation">Observation</option>
                        <option value="minor">Minor</option>
                        <option value="major">Major</option>
                    </select>
                </div>
                <div class="form-group col-md-5">
                    <label>Branch</label>
                    <select name="branch" class="form-control select">
                        <option value="">Empty selection</option>
                        <option>Bacolod</option>
                        <option>Cebu</option>
                        <option>Davao</option>
                        <option>Iloilo</option>
                        <option>Makati</option>
                    </select>
                </div>
                <div class="form-group col-md-5">
                    <label>Tags</label>
                    <input type="text" name="tags" class="form-control">
                </div>
                <div class="form-group col-md-5">
                    <label>Department</label>
                    <select name="department" class="form-control select">
                        <option value="">Empty selection</option>
                        <option>Accounting</option>
                        <option>Human Resource</option>
                        <option>Information Technology</option>
                        <option>Internal Audit</option>
                        <option>Training</option>
                        <option>Research and Development</option>
                        <option>Quality Management Representative</option>
                    </select>
                </div>
                <div class="col-md-5">
                    <label>Date Range (created)</label>
                    <div class="input-group">
                        <input type="text" name="created_at" class="form-control datepicker" value="">
                        <span class="input-group-addon add-on"> - </span>
                        <input type="text" name="updated_at" class="form-control datepicker" value="">
                    </div>
                </div>
            </div>
            <div class="col-md-12 pull-right"><button class="btn btn-success">Submit</button></div>
        </form>
    </div>                            
</div>