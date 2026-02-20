<?php include ('../controller/session.php');
if($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'spr'):
    include('client_header.php');
    $id = $_SESSION['id'];
?> 
<div class="container mt-3">
    <ul class="nav nav-pills">
        <li class="nav-item">
            <a class="nav-link active" href="client_booknew.php">Book New Service</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="client_book_current.php">My Bookings</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="client_book_history.php">History</a>
        </li>
    </ul>
</div>

<!-- Book Service Form -->
<div class="container m-3 p-3 w-auto h-auto border ">
    <h5>Book New Service</h5>
    <form method="POST" action="client_book_process.php?book=yes" name="book_form" enctype="multipart/form-data">
        <div class="mb-3">
            Service Type
            <select class="form-select" id="serviceType" name="serviceType" required>
                <option value="" selected disabled>Select a Service</option>
                <option value="Plumbing">Plumbing</option>
                <option value="Electrical">Electrical</option>
                <option value="Cleaning">Cleaning</option>
                <option value="Painting">Painting</option>
            </select>
        </div>
        <div class="mb-3">
            Preferred Date/Time
            <input type="datetime-local" class="form-control" id="bookingDate" name="bookingDate" required min="<?= date('Y-m-d\TH:i') ?>"></div>
        <div class="mb-3">
            Description
            <textarea class="form-control" id="description" name="description" rows="3" placeholder="Describe your service requirements" required></textarea>
        </div>
        <div class="mb-3">
            Service Location
            <input type="text" class="form-control" name="address" id="address" placeholder="Enter the service location" required>
        </div>
        <div class="mb-3">
            Contact Details
            <input type="number" class="form-control" id="contact" name="contact" placeholder="Enter your phone number" required>
            <script>
            const input = document.getElementById('contact');
            input.addEventListener('input', () => {
                if (input.value.length > 10) {
                    input.value = input.value.slice(0, 10);
                }
            });
            </script>
        </div>
        <div class="mb-3">
            Upload Images (Optional)
            <input type="file" class="form-control" name="images[]" id="images" multiple>
        </div>
        <button type="submit" class="btn btn-primary">Submit Booking</button>
    </form>
</div>

<?php include('client_footer.php'); ?>

<?php 
elseif($_SESSION['role'] == 'spr'):
    header("location: spr_profile.php");
elseif($_SESSION['role'] == 'admin'):
    header("location: admin.php");
endif; ?>
