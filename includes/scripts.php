<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->

<script src="../assets/vendor/libs/jquery/jquery.js"></script>
<script src="../assets/vendor/libs/popper/popper.js"></script>
<script src="../assets/vendor/js/bootstrap.js"></script>
<script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
<script src="../assets/vendor/libs/hammer/hammer.js"></script>
<script src="../assets/vendor/libs/i18n/i18n.js"></script>
<script src="../assets/vendor/libs/typeahead-js/typeahead.js"></script>
<script src="../assets/vendor/js/menu.js"></script>

<!-- endbuild -->

<!-- Vendors JS -->
<script src="../assets/vendor/libs/fullcalendar/fullcalendar.js"></script>
<script src="../assets/vendor/libs/@form-validation/popular.js"></script>
<script src="../assets/vendor/libs/@form-validation/bootstrap5.js"></script>
<script src="../assets/vendor/libs/@form-validation/auto-focus.js"></script>
<script src="../assets/vendor/libs/select2/select2.js"></script>
<script src="../assets/vendor/libs/moment/moment.js"></script>
<script src="../assets/vendor/libs/flatpickr/flatpickr.js"></script>

<!-- Main JS -->
<script src="../assets/js/main.js"></script>

<!-- Calendar Page JS -->
<script src="../assets/js/app-calendar-events.js"></script>
<script src="../assets/js/app-calendar.js"></script>

<!-- Dashboard Page JS -->
<script src="../assets/vendor/libs/apex-charts/apexcharts.js"></script>
<script src="../assets/js/dashboard-analytics.js"></script>

<script>
  $(document).ready(function () {
    // datatable (jquery)

    $(function () {
      var dt_basic_table = $(".table:not(.no-datatable)");
      if (dt_basic_table.length) {
        dt_basic = dt_basic_table.DataTable({
          ordering: true,

          columnDefs: [
            {
              // For Responsive
              className: "control",
              orderable: false,
              responsivePriority: 2,
              targets: 0,
              render: function (data, type, full, meta) {
                return "";
              },
            },

            {
              responsivePriority: 1,
            },
          ],
          dom: '<"card-header flex-column flex-md-row"<"head-label text-center"><"dt-action-buttons text-end pt-3 pt-md-0"B>><"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
          displayLength: 7,
          lengthMenu: [7, 10, 25, 50, 75, 100],

          buttons: [
            {
              extend: "collection",
              className: "btn btn-label-primary dropdown-toggle me-2",
              text: '<i class="bx bx-export me-sm-1"></i> <span class="d-none d-sm-inline-block">Export</span>',
              buttons: [
                {
                  extend: "csv",
                  text: '<i class="bx bx-file me-1" ></i>Csv',
                  className: "dropdown-item",
                  exportOptions: {},
                },
                {
                  extend: "excel",
                  text: '<i class="bx bxs-file-export me-1"></i>Excel',
                  className: "dropdown-item",
                  exportOptions: {},
                },

                {
                  extend: "copy",
                  text: '<i class="bx bx-copy me-1" ></i>Copy',
                  className: "dropdown-item",
                  exportOptions: {
                    columns: [3, 4, 5, 6, 7],
                    // prevent avatar to be displayed
                    format: {
                      body: function (inner, coldex, rowdex) {
                        if (inner.length <= 0) return inner;
                        var el = $.parseHTML(inner);
                        var result = "";
                        $.each(el, function (index, item) {
                          if (
                            item.classList !== undefined &&
                            item.classList.contains("user-name")
                          ) {
                            result =
                              result + item.lastChild.firstChild.textContent;
                          } else if (item.innerText === undefined) {
                            result = result + item.textContent;
                          } else result = result + item.innerText;
                        });
                        return result;
                      },
                    },
                  },
                },
              ],
            },
          ],
          responsive: {
            details: {
              display: $.fn.dataTable.Responsive.display.modal({
                header: function (row) {
                  var data = row.data();
                  return "Details";
                },
              }),
              type: "column",
              renderer: function (api, rowIdx, columns) {
                var data = $.map(columns, function (col, i) {
                  return col.title !== "" // ? Do not show row in modal popup if title is blank (for check box)
                    ? '<tr data-dt-row="' +
                        col.rowIndex +
                        '" data-dt-column="' +
                        col.columnIndex +
                        '">' +
                        "<td>" +
                        col.title +
                        ":" +
                        "</td> " +
                        "<td>" +
                        col.data +
                        "</td>" +
                        "</tr>"
                    : "";
                }).join("");

                return data
                  ? $('<table class="table"/><tbody />').append(data)
                  : false;
              },
            },
          },
        });
        // var cardHeader =dt_basic_table.closest('.card').find('.card-header .card-title');
        //     var cardTitle = cardHeader.text();
        //     cardHeader.remove();
        //     $('div.head-label').html('<h5 class="card-title mb-0">' + cardTitle + '</h5>');
      }

      // Filter form control to default size
      // ? setTimeout used for multilingual table initialization
      setTimeout(() => {
        $(".dataTables_filter .form-control").removeClass("form-control-sm");
        $(".dataTables_length .form-select").removeClass("form-select-sm");
      }, 300);
    });
  });
</script>
