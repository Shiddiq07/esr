<script type="text/javascript">
  var reportPd;
  var reportProdi;

  var defCabang = "<?= $this->session->userdata('kodecabang') ?>";
  var isLokal = Boolean(<?= $this->helpers->isLokal() ?>);

	$(document).ready(function() {
    // INIT CHART PD
		// reportPd = new ApexCharts(document.querySelector("#report-pd"), {
    //   series: [],
    //   chart: {
    //     height: 350,
    //     type: 'line',
    //     zoom: {
    //       enabled: false
    //     }
    //   },
    //   dataLabels: {
    //     enabled: false
    //   },
    //   stroke: {
    //     curve: 'straight'
    //   },
    //   grid: {
    //     row: {
    //       colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
    //       opacity: 0.5
    //     },
    //   },
    //   xaxis: {
    //     categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Des'],
    //   },
    //   noData: {
    //     text: 'Loading...'
    //   }
    // });

    // reportPd.render();
    // INIT CHART PD

    // INIT CHART Cabang
    reportCabang = new ApexCharts(document.querySelector("#report-cabang"), {
      series: [],
      chart: {
        type: 'bar',
        height: 400,
        // stacked: true
      },
    });

    reportCabang.render();
    // INIT CHART Cabang

    // INIT CHART ProDi
		reportProdi = new ApexCharts(document.querySelector("#report-prodi"), {
      series: [],
      chart: {
          type: 'bar',
          height: 400,
          // stacked: true
      },
      plotOptions: {
          bar: {
              horizontal: false,
              columnWidth: '55%',
              endingShape: 'rounded',
              borderRadius: 2,
              dataLabels: {
                position: 'top', // top, center, bottom
              },
          },
      },
      stroke: {
          show: true,
          width: 2,
          colors: ['transparent']
      },
      title: {
          // text: 'Grafik Status Mahasiswa/PD by Prodi'
      },
      dataLabels: {
        enabled: true,
        offsetY: -20,
        style: {
          fontSize: '12px',
          colors: ["#304758"]
        }
      },
      xaxis: {
          categories: [],
      },
      yaxis: {
          title: {
              text: undefined
          }
      },
      tooltip: {
          y: {
              formatter: function (val) {
                  return val
              }
          }
      },
      fill: {
          opacity: 1
      },
      legend: {
          position: 'top',
          horizontalAlign: 'left',
          offsetX: 40
      }
    });

    reportProdi.render();
    // INIT CHART ProDi

    $('#select-periode').trigger('change');
	});

  $(document).on('change', '#select-periode', function(event) {
    event.preventDefault();
    myLoader(true);

    const periode = $(this).val();

    getStatusProdi(periode);
    getSummary(periode);

    if (isLokal) {
      getStatusMhs(defCabang)
    } else {
      getSumCabang(periode);
    }

  });

  $(document).on('change', '#select-graph-type', function(event) {
    event.preventDefault();
    myLoader(true);

    const periode = $('#select-periode').val();

    getStatusProdi(periode);
  });

  $(document).on('click', '#btn-back-graph-mhs', function(event) {
    event.preventDefault();
    /* Act on the event */

    const periode = $('#select-periode').val();

    if (isLokal) {
      getStatusMhs(defCabang)
    } else {
      getSumCabang(periode);
    }

  });

  const getSummary = ((period) => {
    fetch("<?= base_url('/academics/dashboard/get-summary/'. $type) ?>?" + new URLSearchParams({period}), {
      method: 'GET'
    })
      .then((res) => res.json())
      .then((res) => {
        if (!res || (res && res.status == false)) {
          return false;
        }

        const summary = res.summary.data;
        const ta = res.ta;

        // Sum content
        $('#summary-data_awal').text(Number(summary.data_awal).toLocaleString());
        $('#summary-aktif').text(Number(summary.aktif).toLocaleString());
        $('#summary-cuti').text(Number(summary.cuti).toLocaleString());
        $('#summary-non_aktif').text(Number(summary.non_aktif).toLocaleString());
        $('#summary-keluar').text(Number(summary.keluar).toLocaleString());

        // Sum link
        $('#summary-data_awal').parent().parent().parent().parent().find('.filter a').attr('href', `<?= site_url('/academics/dashboard/detail') ?>/<?= $type ?>?periode=${ period }&status=data_awal`);
        $('#summary-aktif').parent().parent().parent().parent().find('.filter a').attr('href', `<?= site_url('/academics/dashboard/detail') ?>/<?= $type ?>?periode=${ period }&status=aktif`);
        $('#summary-cuti').parent().parent().parent().parent().find('.filter a').attr('href', `<?= site_url('/academics/dashboard/detail') ?>/<?= $type ?>?periode=${ period }&status=cuti`);
        $('#summary-non_aktif').parent().parent().parent().parent().find('.filter a').attr('href', `<?= site_url('/academics/dashboard/detail') ?>/<?= $type ?>?periode=${ period }&status=non_aktif`);
        $('#summary-keluar').parent().parent().parent().parent().find('.filter a').attr('href', `<?= site_url('/academics/dashboard/detail') ?>/<?= $type ?>?periode=${ period }&status=keluar`);

        $('#span-ta').text(ta);

        myLoader(false);
      })
  })

  // Get by month mhs/pd
  const getStatusMhs = ((kodeCabang) => {
    myLoader(true);

    const period = $('#select-periode').val();

    fetch("<?= base_url('/academics/dashboard/get-status-mhs/'. $type) ?>?" + new URLSearchParams({period, kodeCabang}), {
      method: 'GET'
    })
      .then((res) => res.json())
      .then((res) => {
        if (res.status) {
          // Update chart
          reportCabang.updateOptions({
            title: {text: res.data.nama_cabang},
            xaxis: {
              categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Des'],
            },
            series: res.data.graphs,
          });
        }

        myLoader(false);

        if (!isLokal) {
          $('#btn-back-graph-mhs').show();
        }
      })
  })

  // Get by month prodi
  const getStatusProdi = ((period) => {
    const graphType = $('#select-graph-type').val();

    $('#select-periode').attr('disabled', true);

    let url = "<?= base_url('/academics/dashboard/get-status-prodi/'. $type) ?>?";

    if (graphType === 'cabang') {
      url = "<?= base_url('/academics/dashboard/get-status-cabang/'. $type) ?>?";
    }

    fetch(url + new URLSearchParams({period}), {
      method: 'GET'
    })
      .then((res) => res.json())
      .then((res) => {
        let tbody = '<tr><td colspan="7"><i>Data belum ada.</i></td></tr>';

        let total_aktif = total_cuti = total_non_aktif = total_drop_out = total_keluar = 0;

        if (res.status) {
          // Update chart
          reportProdi.updateOptions({
             xaxis: {
                categories: typeof res.data.jurusans == 'undefined' ? res.data.cabangs : res.data.jurusans
             },
             series: res.data.graphs,
          });

          // Update table
          tbody = '';

          res.data.summary.forEach((value, key) => {
            let urlDetail = `<?= base_url('/academics/dashboard/detail/'. $type) ?>?periode=${period}`;

            if (graphType === 'cabang') {
              urlDetail += `&kode_cabang=${value.code}`;
            } else {
              urlDetail += `&kode_jurusan=${value.kodejurusan}`;
            }

            const valueAktif = value.aktif > 0 ? `<a href='${urlDetail}&status=aktif'>${ Number(value.aktif).toLocaleString() }</a>` : '-';
            const valueCuti = value.cuti > 0 ? `<a href='${urlDetail}&status=cuti'>${ Number(value.cuti).toLocaleString() }</a>` : '-';
            const valueNonAktif = value.non_aktif > 0 ? `<a href='${urlDetail}&status=non_aktif'>${ Number(value.non_aktif).toLocaleString() }</a>` : '-';
            const valueKeluar = value.keluar > 0 ? `<a href='${urlDetail}&status=keluar'>${ Number(value.keluar).toLocaleString() }</a>` : '-';

            tbody += `<tr>
              <td>${ typeof value.namajurusan != 'undefined' ? value.namajurusan : value.name }</td>
              <td>${ valueAktif }</a></td>
              <td>${ valueCuti }</a></td>
              <td>${ valueNonAktif }</a></td>
              <td>${ valueKeluar }</a></td>
            </tr>`;

            total_aktif += Number(value.aktif);
            total_cuti += Number(value.cuti);
            total_non_aktif += Number(value.non_aktif);
            // total_drop_out += Number(value.drop_out);
            total_keluar += Number(value.keluar);
          });

        }

        $('#table-summary-prodi tbody').empty().append(tbody);

        $('#table-summary-prodi tfoot #total-aktif').text(Number(total_aktif).toLocaleString());
        $('#table-summary-prodi tfoot #total-cuti').text(Number(total_cuti).toLocaleString());
        $('#table-summary-prodi tfoot #total-non_aktif').text(Number(total_non_aktif).toLocaleString());
        // $('#table-summary-prodi tfoot #total-do').text(Number(total_drop_out).toLocaleString());
        $('#table-summary-prodi tfoot #total-keluar').text(Number(total_keluar).toLocaleString());

        myLoader(false);
        $('#select-periode').attr('disabled', false);
      })
  });

  // Get sum cabang
  const getSumCabang = ((period) => {
    // const graphType = $('#select-graph-type').val();

    $('#select-periode').attr('disabled', true);
    $('#btn-back-graph-mhs').hide();

    let url = "<?= base_url('/academics/dashboard/get-sum-cabang/'. $type) ?>?";

    // if (graphType === 'cabang') {
    //   url = "<?= base_url('/academics/dashboard/get-status-cabang/'. $type) ?>?";
    // }

    fetch(url + new URLSearchParams({period}), {
      method: 'GET'
    })
      .then((res) => res.json())
      .then((res) => {
        // let tbody = '<tr><td colspan="7"><i>Data belum ada.</i></td></tr>';

        let total = 0;

        if (res.status) {
          // Update chart
          reportCabang.updateOptions({
            chart: {
              type: 'bar',
              height: 400,
              // stacked: true
            },
            plotOptions: {
              bar: {
                horizontal: false,
                columnWidth: '55%',
                endingShape: 'rounded',
                borderRadius: 2,
                dataLabels: {
                  position: 'top', // top, center, bottom
                },
              },
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            dataLabels: {
              enabled: true,
              offsetY: -20,
              style: {
                fontSize: '12px',
                colors: ["#304758"]
              }
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return val
                    }
                }
            },
            fill: {
                opacity: 1
            },
            legend: {
                position: 'top',
                horizontalAlign: 'left',
                offsetX: 40
            },
            xaxis: {
                // categories: typeof res.data.jurusans == 'undefined' ? res.data.cabangs : res.data.jurusans
                categories: res.data.cabangs
            },
            series: [res.data.graphs],
            title: {
              text: "Hasil per Cabang",
              offsetY: 0
            },
            subtitle: {
              text: "(Klik bar untuk lihat detil)",
              offsetY: 20
            },
            chart: {
              events: {
                dataPointSelection: function (e, chart, config) {
                  let dataPoint = config.w.config.series[config.seriesIndex].data[config.dataPointIndex];
                  let kodeCabang = dataPoint.code;

                  if (!kodeCabang) return false;

                  reportCabang.updateOptions({
                    title: {text: dataPoint.x},
                    subtitle: {text: ''}
                  });

                  getStatusMhs(kodeCabang);
                },
              },
            }
          });

          // Update table
          // tbody = '';

          res.data.summary.forEach((value, key) => {
            // let urlDetail = `<?= base_url('/academics/dashboard/detail/'. $type) ?>?periode=${period}`;

            // if (graphType === 'cabang') {
            //   urlDetail += `&kode_cabang=${value.code}`;
            // } else {
            //   urlDetail += `&kode_jurusan=${value.kodejurusan}`;
            // }

            // const valueAktif = value.aktif > 0 ? `<a href='${urlDetail}&status=aktif'>${ Number(value.aktif).toLocaleString() }</a>` : '-';
            // const valueCuti = value.cuti > 0 ? `<a href='${urlDetail}&status=cuti'>${ Number(value.cuti).toLocaleString() }</a>` : '-';
            // const valueNonAktif = value.non_aktif > 0 ? `<a href='${urlDetail}&status=non_aktif'>${ Number(value.non_aktif).toLocaleString() }</a>` : '-';
            // const valueKeluar = value.keluar > 0 ? `<a href='${urlDetail}&status=keluar'>${ Number(value.keluar).toLocaleString() }</a>` : '-';

            // tbody += `<tr>
            //   <td>${ value.name }</td>
            //   <td>${ value.total }</a></td>
            // </tr>`;

            // total += Number(value.total);
          });

        }

        // $('#table-summary-cabang tbody').empty().append(tbody);

        // $('#table-summary-cabang tfoot #total').text(Number(total).toLocaleString());

        myLoader(false);
        $('#select-periode').attr('disabled', false);
      })
  });

</script>
