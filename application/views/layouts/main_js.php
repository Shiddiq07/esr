<!-- Vendor JS Files -->
<script src="<?= base_url('web/assets/vendor/apexcharts/apexcharts.min.js') ?>"></script>
<script src="<?= base_url('web/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('web/assets/vendor/chart.js/chart.umd.js') ?>"></script>
<script src="<?= base_url('web/assets/vendor/echarts/echarts.min.js') ?>"></script>
<script src="<?= base_url('web/assets/vendor/quill/quill.js') ?>"></script>
<!-- <script src="<?php //base_url('web/assets/vendor/simple-datatables/simple-datatables.js') ?>"></script> -->
<script src="<?= base_url('web/assets/vendor/tinymce/tinymce.min.js') ?>"></script>
<script src="<?= base_url('web/assets/vendor/php-email-form/validate.js') ?>"></script>

<!-- Template Main JS File -->
<script src="<?= base_url('web/assets/js/main.js') ?>"></script>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="<?= base_url('web/assets/vendor/simple-datatables/datatables.all.min.js') ?>"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?= base_url('web/assets/js/my_custom.js') ?>"></script>
<script src="<?= base_url('web/assets/js/yii.js') ?>"></script>
<script src="<?= base_url('web/assets/js/jquery.timeago.js') ?>"></script>

<script src="https://cdn.jsdelivr.net/npm/@algolia/autocomplete-js"></script>
<script>
  const { autocomplete } = window['@algolia/autocomplete-js'];
</script>

<?php 
# Load self-made file views for setting js
if (!empty($view_js)) {
	if (is_string($view_js)) {
		$this->load->view($view_js);

	} elseif (is_array($view_js)) {
		foreach ($view_js as $key => $js) {
			$this->load->view($js);
		}

	}

}
?>

<script type="text/javascript" id="refresh-token">
	/**
   * [Auto refresh token csrf]
   */
  setInterval(() => {
    $.ajax({
      url: '<?= site_url('/site/refresh-csrf') ?>',
      type: 'POST',
      dataType: 'json',
      global: false,
    })
    .done(function(res) {
      csrf_name = res.csrfName;
      csrf_hash = res.csrfHash;
    });
    
  }, (csrf_expires * 1000));
</script>

<script type="text/javascript">
  $(document).on('click', '#link-logout', function(event) {
    event.preventDefault();
    /* Act on the event */

    let link = $(this).attr('href');

    customConfirmation({
      message: 'Apakah Anda juga ingin logout dari aplikasi HRIS?'
    }, (confirm) => {
      if (confirm) {
        link += '?hris=true'
      }

      document.location.href = link;
    })
  });

  $(document).ready(function() {
    $('time.timeago').timeago();
  });
</script>

<script type="text/javascript" id="algolia">
  autocomplete({
    container: '#autocomplete',
    placeholder: 'Search menu',
    getSources({ query }) {
      return [{
        getItems() {
          return fetch("<?= base_url('/rbac/menu/search') ?>?" + new URLSearchParams({ term: query }), {
            method: 'GET'
          })
          .then((res) => res.json())
          .then((data) => {
            return data;
          });
        },
        templates: {
          item({ item, components, html }) {
            // const highlight = components.Highlight({
            //   hit: item,
            //   attribute: 'label',
            // });

            const snippet = components.Snippet({
              hit: item,
              attribute: 'description',
            });

            return html`<div class="aa-ItemWrapper">
              <div class="aa-ItemContent">
                <div class="aa-ItemContentBody">
                  <div class="aa-ItemContentTitle PrimaryAttribute">
                    <b>${ item.label }</b>
                  </div>
                  <div class="aa-ItemContentDescription SecondAttribute">
                    ${ item.url }
                  </div>
                  <div class="aa-ItemContentDescription ThirdAttribute">
                    ${ snippet }
                  </div>
                </div>
                <div class="aa-ItemActions">
                  <a href="<?= base_url() ?>${ item.url.substr(1) }"
                    class="aa-ItemActionButton aa-DesktopOnly aa-ActiveOnly"
                    title="Select"
                  >
                    <svg
                      viewBox="0 0 24 24"
                      width="20"
                      height="20"
                      fill="currentColor"
                    >
                      <path
                        d="M18.984 6.984h2.016v6h-15.188l3.609 3.609-1.406 1.406-6-6 6-6 1.406 1.406-3.609 3.609h13.172v-4.031z"
                      />
                    </svg>
                  </a>
                </div>
              </div>
            </div>`;
          }
        }
      }]
    },
  });

</script>
