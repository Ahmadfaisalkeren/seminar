<div class="modal fade" id="ajaxModel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="seminarForm" name="seminarForm" class="form-horizontal" enctype="multipart/form-data">
                    <input type="hidden" name="seminar_id" id="seminar_id">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="seminar_name" class="col-sm-2 control-label">Seminar Name</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="seminar_name" name="seminar_name"
                                        placeholder="Seminar Name" value="" maxlength="50" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="organizer" class="col-sm-2 control-label">Organizer</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="organizer" name="organizer"
                                        placeholder="Organizer" value="" maxlength="50" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="contact" class="col-sm-2 control-label">Contact</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="contact" name="contact"
                                        placeholder="Contact" value="" maxlength="50" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="place" class="col-sm-2 control-label">Place</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="place" name="place"
                                        placeholder="Place" value="" maxlength="50" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="speaker" class="col-sm-2 control-label">Speaker</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="speaker" name="speaker"
                                        placeholder="Speaker" value="" maxlength="50" required="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="seminar_date" class="col-sm-2 control-label">Seminar Date</label>
                                <div class="col-sm-12">
                                    <input type="date" class="form-control" id="seminar_date" name="seminar_date"
                                        placeholder="Seminar Date" value="" maxlength="50" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="price" class="col-sm-2 control-label">Price</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="price" name="price"
                                        placeholder="Price" value="" maxlength="50" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="quota" class="col-sm-2 control-label">Quota</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="quota" name="quota"
                                        placeholder="Quota" value="" maxlength="50" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="image" class="col-sm-2 control-label">Image</label>
                                <div class="col-sm-12">
                                    <input type="file" class="form-control" id="image" name="image"
                                    placeholder="Image" value="" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="description" class="col-sm-2 control-label">Description</label>
                                <div class="col-sm-12">
                                    <textarea class="form-control" id="description" name="description"
                                        placeholder="Description" value="" maxlength="50" required=""></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary" id="saveBtnNew">Save</button>
                            <button type="submit" class="btn btn-primary" id="saveBtnEdit">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
