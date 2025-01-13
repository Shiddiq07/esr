<script type="text/javascript">
  const src = '<?= !empty($src) ? $src : null ?>';
  const defCabang = '<?= $this->helpers->isLokal() ? $this->session->userdata('kodecabang') : '' ?>';
</script>

<script type="text/javascript">
	$(document).ready(function() {
    // INIT CHART ProDi
    reportPenempatan = new ApexCharts(document.querySelector("#graph-penempatan"), {
      series: [],
      chart: {
        type: 'bar',
        height: 350,
        stacked: true,
        toolbar: {
          show: true
        },
        zoom: {
          enabled: true
        }
      },
      responsive: [{
        breakpoint: 480,
        options: {
          legend: {
            position: 'bottom',
            offsetX: -10,
            offsetY: 0
          }
        }
      }],
      plotOptions: {
        bar: {
          horizontal: false,
          borderRadius: 2,
          borderRadiusApplication: 'end', // 'around', 'end'
          borderRadiusWhenStacked: 'last', // 'all', 'last'
          dataLabels: {
            total: {
              enabled: true,
              style: {
                fontSize: '13px',
                fontWeight: 900
              }
            }
          }
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
      legend: {
          position: 'top',
          horizontalAlign: 'left',
          offsetX: 40
      }
    });

    reportPenempatan.render();
    // INIT CHART ProDi

    // INIT CHART PERUSAHAAN
    reportPerusahaan = new ApexCharts(document.querySelector("#graph-perusahaan"), {
      series: [],
      chart: {
        // width: 420,
        type: 'pie',
      },
      labels: [],
      responsive: [{
        breakpoint: 480,
        options: {
          chart: {
            // width: 200
          },
          legend: {
            position: 'bottom'
          }
        }
      }]
    });

    reportPerusahaan.render();
    // INIT CHART PERUSAHAAN

    // INIT CHART KETERANGAN
    reportKeterangan = new ApexCharts(document.querySelector("#graph-keterangan"), {
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

    reportKeterangan.render();
    // INIT CHART KETERANGAN

    // INIT CHART PERMINTAAN
    reportPermintaan = new ApexCharts(document.querySelector("#graph-permintaan"), {
      series: [{
        name: "Alumni",
        data: []
      }],
      chart: {
        type: 'area',
        height: 350,
        zoom: {
          enabled: false
        }
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        curve: 'straight'
      },
      title: {
        // text: 'Fundamental Analysis of Stocks',
        // align: 'left'
      },
      subtitle: {
        // text: 'Price Movements',
        // align: 'left'
      },
      labels: [],
      xaxis: {},
      yaxis: {},
      legend: {
        horizontalAlign: 'left'
      }
    });

    reportPermintaan.render();
    // INIT CHART PERMINTAAN

		$('#select-tahun_angkatan').trigger('change');
    $('#select-keterangan').trigger('change');
    $('#select-status_mou').trigger('change');
    $('#select-tahun_permintaan').trigger('change');
	});

	$(document).on('change', '#select-tahun_angkatan', function(event) {
    event.preventDefault();
    myLoader(true);

    const tahun_angkatan = $(this).val();
    const cabang = $('#select-cabang').val();

    getSummary(tahun_angkatan);
    getRecapPlacement(tahun_angkatan, cabang);
    getRecapKeterangan(tahun_angkatan);
  });

  $(document).on('change', '#select-cabang', function(event) {
    event.preventDefault();
    myLoader(true);

    const tahunAngkatan = $('#select-tahun_angkatan').val();
    const cabang = $('#select-cabang').val();

    getRecapPlacement(tahunAngkatan, cabang);
  });

  $(document).on('change', '#select-status_mou, #select-is_contributed', function(event) {
    event.preventDefault();
    /* Act on the event */

    const status_mou = $('#select-status_mou').val();
    const is_contributed = $('#select-is_contributed').val();

    getRecapScale(status_mou, is_contributed);
  });

  $(document).on('change', '#select-tahun_permintaan', function(event) {
    event.preventDefault();
    myLoader(true);

    const tahun_permintaan = $(this).val();

    getRecapPermintaan(tahun_permintaan);
  });

	const getSummary = ((tahun_angkatan) => {
    fetch("<?= base_url('/cnp/dashboard/get-summary/'. $type) ?>?" + new URLSearchParams({tahun_angkatan}), {
      method: 'GET'
    })
      .then((res) => res.json())
      .then((res) => {
        if (!res || (res && res.status == false)) {
          return false;
        }

        const summary = res.summary;
        const tahun_angkatan = res.tahun_angkatan;

        // Sum content
        $('#summary-total_alumni').text(summary.total_alumni);
        $('#summary-non_target').text(summary.non_target);
        $('#summary-total_target').text(summary.total_target);
        $('#summary-by_cnp').text(summary.by_cnp);
        $('#summary-sendiri').text(summary.sendiri);
        $('#summary-wirausaha').text(summary.wirausaha);
        $('#summary-on_progres').text(summary.on_progres);

        // Percentage content
        <?php //$('#percentage-non_target_perc').text(summary.non_target_perc); ?>
        $('#percentage-by_cnp_perc').text(`${summary.by_cnp_perc}%`);
        $('#percentage-sendiri_perc').text(`${summary.sendiri_perc}%`);
        $('#percentage-wirausaha_perc').text(`${summary.wirausaha_perc}%`);
        $('#percentage-proses_perc').text(`${summary.proses_perc}%`);

        // Sum link
        $('#summary-total_alumni').parent().find('a').attr('href', `<?= site_url('/cnp/dashboard/detail') ?>/<?= $type ?>?tahun_angkatan=${ tahun_angkatan }&jenis=total_alumni`);
        $('#summary-non_target').parent().find('a').attr('href', `<?= site_url('/cnp/dashboard/detail') ?>/<?= $type ?>?tahun_angkatan=${ tahun_angkatan }&jenis=non_target`);
        $('#summary-total_target').parent().find('a').attr('href', `<?= site_url('/cnp/dashboard/detail') ?>/<?= $type ?>?tahun_angkatan=${ tahun_angkatan }&jenis=total_target`);
        $('#summary-by_cnp').parent().find('a').attr('href', `<?= site_url('/cnp/dashboard/detail') ?>/<?= $type ?>?tahun_angkatan=${ tahun_angkatan }&jenis=by_cnp`);
        $('#summary-sendiri').parent().find('a').attr('href', `<?= site_url('/cnp/dashboard/detail') ?>/<?= $type ?>?tahun_angkatan=${ tahun_angkatan }&jenis=sendiri`);
        $('#summary-wirausaha').parent().find('a').attr('href', `<?= site_url('/cnp/dashboard/detail') ?>/<?= $type ?>?tahun_angkatan=${ tahun_angkatan }&jenis=wirausaha`);
        $('#summary-on_progres').parent().find('a').attr('href', `<?= site_url('/cnp/dashboard/detail') ?>/<?= $type ?>?tahun_angkatan=${ tahun_angkatan }&jenis=on_progres`);

        $('#span-ta').text(tahun_angkatan);

        setTimeout(() => {
          $('title').text($('.pagetitle h1').text() +' | <?= APP_FULLNAME ?>')
        }, 1000)

        myLoader(false);
      })
  });

  const getRecapPlacement = ((tahun_angkatan, cabang = '') => {
    fetch("<?= base_url('/cnp/dashboard/get-placement/'. $type) ?>?" + new URLSearchParams({tahun_angkatan, cabang}), {
      method: 'GET'
    })
      .then((res) => res.json())
      .then((res) => {
        let tbody = `<tr><td colspan="6"><i>Data belum ada.</i></td></tr>`;

        if (res) {
          reportPenempatan.updateOptions({
             xaxis: {
                categories: res.columns
             },
             series: res.graphs,
          });

          if (res.summary && res.summary.length > 0) {
            // Update table
            tbody = '';

            res.summary.forEach((value, key) => {
              // let urlDetail = `<?= base_url('/academics/dashboard/detail/'. $type) ?>?periode=${period}`;

              // if (graphType === 'cabang') {
              //   urlDetail += `&kode_cabang=${value.code}`;
              // } else {
              //   urlDetail += `&kode_jurusan=${value.kodejurusan}`;
              // }

              const valueTotalTarget = value.total_target > 0 ? value.total_target : '-';
              const valueByCnp = value.by_cnp > 0 ? value.by_cnp : '-';
              const valueSendiri = value.sendiri > 0 ? value.sendiri : '-';
              const valueWirausaha = value.wirausaha > 0 ? value.wirausaha : '-';
              const valueProses = value.proses > 0 ? value.proses : '-';

              tbody += `<tr>
                <td>${ typeof value.namajurusan != 'undefined' ? value.namajurusan : value.name }</td>
                <td align="right">${ valueByCnp }</td>
                <td align="right">${ valueSendiri }</td>
                <td align="right">${ valueWirausaha }</td>
                <td align="right">${ valueProses }</td>
                <td align="right">${ valueTotalTarget }</td>
              </tr>`;
            });
          }
        }

        $('#table-penempatan tbody').empty().append(tbody);

        myLoader(false);
      })
  });

  const getRecapScale = ((status_mou = '', is_contributed = '') => {
    fetch("<?= base_url('/cnp/dashboard/get-graph-scale/'. $type) ?>?" + new URLSearchParams({status_mou, is_contributed}), {
      method: 'GET'
    })
      .then((res) => res.json())
      .then((res) => {
        let tbody = `<tr><td colspan="2"><i>Data belum ada.</i></td></tr>`;
        let total = 0;

        if (res) {
          reportPerusahaan.updateOptions({
             // xaxis: {
             //    categories: res.columns
             // },
             labels: res.series,
             series: res.values,
          });

          if (res.data && res.data.length > 0) {
            // Update table
            tbody = '';

            res.data.forEach((value, key) => {
              const jumlah = value.value > 0 ? Number(value.value).toLocaleString() : '-';
              total += Number(value.value);

              tbody += `<tr>
                <td>${ value.skala }</td>
                <td align="right">${ jumlah }</td>
              </tr>`;
            });
          }
        }

        $('#table-perusahaan tbody').empty().append(tbody);
        $('#perusahaan-total').text(Number(total).toLocaleString());

        myLoader(false);
      })
  });

  const getRecapKeterangan = ((tahun_angkatan) => {
    fetch("<?= base_url('/cnp/dashboard/get-graph-failure/'. $type) ?>?" + new URLSearchParams({tahun_angkatan}), {
      method: 'GET'
    })
      .then((res) => res.json())
      .then((res) => {
        // let tbody = `<tr><td colspan="2"><i>Data belum ada.</i></td></tr>`;

        if (res) {
          reportKeterangan.updateOptions({
             xaxis: {
                categories: res.columns
             },
             series: [{data: res.series}],
             yaxis: {
              title: {
                text: `Tahun ${tahun_angkatan}`
              }
             }
          });

          // if (res.data && res.data.length > 0) {
          //   // Update table
          //   tbody = '';

          //   res.data.forEach((value, key) => {
          //     // let urlDetail = `<?= base_url('/academics/dashboard/detail/'. $type) ?>?periode=${period}`;

          //     // if (graphType === 'cabang') {
          //     //   urlDetail += `&kode_cabang=${value.code}`;
          //     // } else {
          //     //   urlDetail += `&kode_jurusan=${value.kodejurusan}`;
          //     // }

          //     const valueTotalTarget = value.total_target > 0 ? value.total_target : '-';
          //     const valueByCnp = value.by_cnp > 0 ? value.by_cnp : '-';
          //     const valueSendiri = value.sendiri > 0 ? value.sendiri : '-';
          //     const valueWirausaha = value.wirausaha > 0 ? value.wirausaha : '-';
          //     const valueProses = value.proses > 0 ? value.proses : '-';

          //     tbody += `<tr>
          //       <td>${ typeof value.namajurusan != 'undefined' ? value.namajurusan : value.name }</td>
          //       <td align="right">${ valueTotalTarget }</td>
          //       <td align="right">${ valueByCnp }</td>
          //       <td align="right">${ valueSendiri }</td>
          //       <td align="right">${ valueWirausaha }</td>
          //       <td align="right">${ valueProses }</td>
          //     </tr>`;
          //   });
          // }
        }

        // $('#table-penempatan tbody').empty().append(tbody);

        myLoader(false);
      })
  });

  const getRecapPermintaan = ((tahun_permintaan) => {
    fetch("<?= base_url('/cnp/dashboard/get-graph-request/'. $type) ?>?" + new URLSearchParams({tahun_permintaan}), {
      method: 'GET'
    })
      .then((res) => res.json())
      .then((res) => {
        // let tbody = `<tr><td colspan="2"><i>Data belum ada.</i></td></tr>`;

        if (res) {
          reportPermintaan.updateOptions({
             xaxis: {
                categories: res.columns
             },
             series: [{data: res.values}],
             yaxis: {
              title: {
                text: `Tahun ${tahun_permintaan}`
              }
             }
          });
        }

        myLoader(false);
      })
  });
</script>