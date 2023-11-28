<!-- jQuery -->
<script src="vendor/adminlte/plugins/jquery/jquery.min.js"></script>
<script>
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
</script>
<!-- jQuery UI 1.11.4 -->
<script src="vendor/adminlte/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="vendor/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="vendor/adminlte/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="vendor/adminlte/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="vendor/adminlte/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="vendor/adminlte/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="vendor/adminlte/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="vendor/adminlte/plugins/moment/moment.min.js"></script>
<script src="vendor/adminlte/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="vendor/adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="vendor/adminlte/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="vendor/adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- Custom UI -->
<script src="js/custom_ui.js"></script>
<!-- AdminLTE App -->
<script src="vendor/adminlte/dist/js/adminlte.js"></script>
<script src="vendor/adminlte/dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="vendor/adminlte/dist/js/pages/dashboard.js"></script>
<!-- CKEditor -->
<script src="vendor/ckeditor4/ckeditor.js"></script>
<!-- CKFinder -->
<script src="vendor/ckfinder/ckfinder.js"></script>
<!-- Fancybox -->
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
<script>
  const configCkeditor = {
    height: 400,
    filebrowserBrowseUrl     : "{{ route('ckfinder_browser') }}",
    filebrowserImageBrowseUrl: "{{ route('ckfinder_browser') }}?type=Images&token=123",
    filebrowserFlashBrowseUrl: "{{ route('ckfinder_browser') }}?type=Flash&token=123", 
    filebrowserUploadUrl     : "{{ route('ckfinder_connector') }}?command=QuickUpload&type=Files", 
    filebrowserImageUploadUrl: "{{ route('ckfinder_connector') }}?command=QuickUpload&type=Images",
    filebrowserFlashUploadUrl: "{{ route('ckfinder_connector') }}?command=QuickUpload&type=Flash",
  }
</script>
<!-- Datatable -->
<script src="vendor/adminlte/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="vendor/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<!-- Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!-- Datepicker -->
<script src="https://unpkg.com/js-datepicker"></script>
<script>
  $(document).ready(function() {
    $('.select-2').select2();
  });
  // Init Fancybox
  Fancybox.bind("[data-fancybox]");
  // Datepick
  function getJsDateObjecrt(ymdString)
  {
    const [year, month, day] = ymdString.split('-').map(Number);
    return new Date(year, month - 1, day);
  }
  function formatDate(date)
  {
    var d = new Date(date),
    month = '' + (d.getMonth() + 1),
    day = '' + d.getDate(),
    year = d.getFullYear();

    if (month.length < 2) 
      month = '0' + month;
    if (day.length < 2) 
      day = '0' + day;

    return [year, month, day].join('-');
  }
  function formatDateToDmy(date)
  {
    const day = date.getDate();
    const month = date.getMonth() + 1;
    const year = date.getFullYear();

    return `${day}-${month}-${year}`;
  }
  function handleDatePicker(id, hiddenId, position, rangeDate)
  {
    const configDate = {
      customDays: ['T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'CN'],
      customMonths: ['T1', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'T8', 'T9', 'T10', 'T11', 'T12'],
      position: position,
      formatter: (input, date, instance) => {
        //const value = date.toLocaleDateString('vi-VN');
        input.value = formatDateToDmy(date);
      },
      minDate : rangeDate?.minDate,
      startDate : rangeDate?.startDate,
    }
    datepicker(id, {
      ...configDate,
      onSelect : function(instance, date) {
        $(hiddenId).val(formatDate(date));
        console.log(formatDate(date));
      }
    });
  }
</script>
<script src="https://www.gstatic.com/firebasejs/5.5.8/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/5.5.8/firebase-messaging.js"></script>
<script>
  // Initialize Firebase
  const config = {
    apiKey: "AIzaSyCXklG232X3RFoUI9fbLbchcOUjOoO4QGo",
    authDomain: "test-b15ce.firebaseapp.com",
    projectId: "test-b15ce",
    storageBucket: "test-b15ce.appspot.com",
    messagingSenderId: "808179491697",
    appId: "1:808179491697:web:163cd8c2719cbe50e88cd0"
  };
  firebase.initializeApp(config);
  const messaging = firebase.messaging();
  // Request browser notification
  messaging.requestPermission().then(function() {
    console.log('Notification is active');
  }).catch(function(err) {
    console.log('Unable to get permission to notify.', err);
  });
  // Get device token
  let storeDeviceToken = localStorage.getItem('fcm_device_token');
  messaging.getToken().then(function(currentToken) {
    if (storeDeviceToken != currentToken) {
      $.ajax({
        url: "{{route('family_member.store_device_token')}}",
        type: 'POST',
        data: {
          fcm_device_token : currentToken
        },
        success: function(data) {
          console.log(data);
          localStorage.setItem('fcm_device_token', currentToken);
        },
        error: function (res, stt, error) {
          
        }
      });
    }
  }).catch(function(err) {
    console.log(err);
  });
</script>