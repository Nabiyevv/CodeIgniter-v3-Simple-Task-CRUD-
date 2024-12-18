<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit Task</title>
    <link href="<?= base_url('assets/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
</head>

<body>
    <?php $this->load->view('components/navbar'); ?>
    <div class="container mt-4">
        <h2>Edit Task</h2>
		<?php echo validation_errors(); ?>
        <?php echo form_open_multipart('update/'.$task->id);?>
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" class="form-control <?= (form_error('name') ? 'is-invalid' : '') ?>" required
                 value="<?= $task->name ?>">
                 <?php echo "<div class='invalid-feedback'> ".form_error('name')." </div>"  ?>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" 
                class="form-control <?= (form_error('description') ? 'is-invalid' : '') ?>"><?= $task->description ?></textarea>
                <?php echo "<div class='invalid-feedback'> ".form_error('description')." </div>"  ?>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Upload Image</label>
                <input name="image" class="form-control" 
                type="file" accept="image/*" id="image">

                <img src="<?= base_url('uploads/images/'.$task->image) ?>" id="imagePreview" class="mt-3" width="100px">

            </div>
            <div class="mb-3">
                <label for="deadline" class="form-label">Deadline</label>
                <input type="date" name="deadline" class="form-control" required 
                value="<?= $task->deadline ?>">
                <?php echo "<div class='invalid-feedback'> ".form_error('deadline')." </div>"  ?>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
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
