<!DOCTYPE html>
<html lang="en">

<head>
    <title>Create Task</title>

    <link href="<?= base_url('assets/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
</head>

<body>
    <?php $this->load->view('components/navbar'); ?>
    <div class="container mt-4">
        <h2>Create Task</h2>
        <?php if($this->session->flashdata('error')): ?>
            <div class="alert alert-danger show">
                <?php echo $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>
        <?php echo validation_errors(); ?>
        <?php echo form_open_multipart('store');?>
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" class="form-control <?= (form_error('name') ? 'is-invalid' : '') ?>"
                 value="<?php echo set_value('name'); ?>">
                 <?php echo "<div class='invalid-feedback'> ".form_error('name')." </div>"  ?>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" class="form-control <?= (form_error('description') ? 'is-invalid' : '') ?>"><?php echo set_value('description'); ?></textarea>
                <?php echo "<div class='invalid-feedback'> ".form_error('description')." </div>"  ?>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Upload Image</label>
                <input name="image" class="form-control" type="file" accept="image/*" id="image">
            </div>
            <div class="mb-3">
                <label for="deadline" class="form-label">Deadline</label>
                <input type="date" name="deadline" class="form-control" required 
                value="<?php echo set_value('deadline'); ?>">
                <?php echo "<div class='invalid-feedback'> ".form_error('deadline')." </div>"  ?>
            </div>
            <input type="submit" class="btn btn-primary"></input>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="<?= base_url('assets/bootstrap/js/bootstrap.min.js') ?>"></script>

    <!-- jQuery -->
    <script src="<?= base_url('assets/jquery/jquery-3.7.1.min.js') ?>"></script>

    <!-- Popper JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Preview Image -->
    <script>
        $(document).ready(function() {
            $('#image').change(function() {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagePreview').remove();
                    $('<img>', {
                        id: 'imagePreview',
                        src: e.target.result,
                        class: 'img-thumbnail mt-3',
                        width: '100px'
                    }).insertAfter('#image');
                }
                reader.readAsDataURL(this.files[0]);
            });
        });
    </script>



</body>

</html>