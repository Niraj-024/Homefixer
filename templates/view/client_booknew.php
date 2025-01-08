<?php include ('../controller/session.php');
if($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'spr'):
    include('client_header.php');
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
    <form>
        <div class="mb-3">
            Service Type
            <select class="form-select" id="serviceType" required>
                <option value="" selected disabled>Select a Service</option>
                <option value="plumbing">Plumbing</option>
                <option value="electrical">Electrical</option>
                <option value="cleaning">Cleaning</option>
                <option value="painting">Painting</option>
            </select>
        </div>
        <div class="mb-3">
            Preferred Date/Time
            <input type="datetime-local" class="form-control" id="bookingDate" required>
        </div>
        <div class="mb-3">
            Description
            <textarea class="form-control" id="description"  rows="3" placeholder="Describe your service requirements" required></textarea>
        </div>
        <div class="mb-3">
            Service Location
            <input type="text" class="form-control" id="address" placeholder="Enter the service location" required>
        </div>
        <div class="mb-3">
            Contact Details
            <input type="number" class="form-control" id="contact" placeholder="Enter your phone number" >
            <script>
            const input = document.getElementById('contact');
            input.addEventListener('input', () => {
                if (input.value.length > 10) {
                    input.value = input.value.slice(0, 10);
                }
            });
            </script>
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