<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TODO List</title>

  <link href="<?= base_url('assets/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
  <style>
    /* .todo-card {
      border-radius: 8px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    } */
  </style>
</head>

<body>

  <?php $this->load->view('components/navbar'); ?>

  <?php if ($this->session->flashdata('success')) { ?>
    <div class="alert alert-success" style="position: absolute; top: 40px; right: 40px;" role="alert">
      <?= $this->session->flashdata('success') ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  <?php } ?>

  <div class="container my-5">
    <!-- Title -->
    <div class="text-center mb-4">
      <h1 class="display-6">Task List</h1>
    </div>

    <!-- Search Bar -->
    <div class="row justify-content-center mb-4">
      <div class="col-md-6">
        <input
          type="text"
          id="searchInput"
          class="form-control"
          placeholder="Search tasks..."
          onkeyup="searchTask()" />
      </div>
    </div>

    <!-- TODO List -->


    <div class="row row-cols-1 row-cols-md-3 g-4" id="todoList">
      <!-- Example TODO items -->
      <?php foreach ($tasks as $task) { ?>

        <div class="col" style="width: 18rem;">
          <div class="card h-100">
            <img loading="lazy" 
            src="<?= $task->image ? base_url('uploads/images/' . $task->image) : "https://via.placeholder.com/460x280.png/0055ee?text=".$task->name ?>"
            class="card-img-top bd-placeholder-img" height="180px" alt="..."> 
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title"><?= $task->name ?> </h5>
                <small class="text-muted">
                  <i class="bi bi-calendar-check me-1"></i>
                  <?= $task->deadline ?>
                </small>
              </div>
              <p class="card-text"><?= $task->description ?></p>
              <div class="btn-group" role="group">
                <a href="edit/<?= $task->id  ?>" type="button" class="btn btn-sm btn-outline-secondary edit-btn">
                  <i class="bi bi-pencil"></i> Edit
                </a>
                <button onclick="deleteTask(<?= $task->id ?>)" type="button" class="btn btn-sm btn-outline-danger delete-btn">
                  <i class="bi bi-trash"></i> Delete
                </button>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>



  </div>

  <!-- Bootstrap JS -->
  <script src="<?= base_url('assets/bootstrap/js/bootstrap.min.js') ?>"></script>

  <!-- jQuery -->
  <script src="<?= base_url('assets/jquery/jquery-3.7.1.min.js') ?>"></script>

  <!-- Popper JS -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>

  <!-- SweetAlert2 -->
  <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
  <script src="<?= base_url('assets/sweetalert2/sweetalert2@11.js') ?>"></script>

  <script>
    setTimeout(() => {
      $('.alert').each(function() {
      $(this).removeClass('show').addClass('fade');
      setTimeout(() => $(this).remove(), 500);
      });
    }, 3000);
  </script>


  <!-- Search Filtering -->
  <script>
    function deleteTask(taskId) {
      Swal.fire({
        title: "Are you sure delete this task?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: 'delete/' + taskId,
            type: 'POST',
            success: function(response) {
              Swal.fire(
                'Deleted!',
                'Your task has been deleted.',
                'success'
              ).then(() => {
                location.reload();
              });
            },
            error: function(xhr, status, error) {
              Swal.fire(
                'Error!',
                'There was an error deleting the task.',
                'error'
              );
            }
          });
        }
      });
    }

    const searchTask = debounce(function(){
      console.log('searching...');
      let searchInput = $('#searchInput').val();
      if(searchInput.length > 0) {
        $.ajax({
          url: 'search',
          type: 'POST',
          data: { search: searchInput },
          success: function(response) {
            let taskList = $('#todoList');
            taskList.empty();
            response.forEach(task => {
              taskList.append(cardItem(task));
            });
          },
          error: function(xhr, status, error) {
            console.error(error);
          }
        });
      } else {
        location.reload();
      }

    },500)

    function debounce(func, delay) {
        let timer;
        return function (...args) {
            const context = this;
            clearTimeout(timer);
            timer = setTimeout(() => func.apply(context, args), delay);
        };
    }

    const cardItem = (task) =>{
      return `<div class="col" style="width: 18rem;">
          <div class="card h-100">
          <img loading="lazy" 
            src="${task.image ? '/uploads/images/' + task.image : 'https://via.placeholder.com/460x280.png/0055ee?text='+task.name}" }
            class="card-img-top bd-placeholder-img" height="180px" alt="..."> 
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title">${task.name}</h5>
                <small class="text-muted">
                  <i class="bi bi-calendar-check me-1"></i>
                  ${task.deadline}
                </small>
              </div>
              <p class="card-text">${task.description}</p>
              <div class="btn-group" role="group">
                <a href="edit/${task.id}" type="button" class="btn btn-sm btn-outline-secondary edit-btn">
                  <i class="bi bi-pencil"></i> Edit
                </a>
                <button onclick="deleteTask(${task.id})" type="button" class="btn btn-sm btn-outline-danger delete-btn">
                  <i class="bi bi-trash"></i> Delete
                </button>
              </div>
            </div>
          </div>
        </div>`
    }

  </script>
</body>

</html>