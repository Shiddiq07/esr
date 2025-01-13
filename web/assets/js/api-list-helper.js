const getTahunBiodata = async (id, cabang, label = '- Pilih -', $default = null) => {
	(async () => {
	    try {
	        // GET Request Example
	        const listTahun = await fetchData(`${ baseUrl }api/list-dropdown/tahun-biodata/${ src }`, 'GET', {cabang});

	        if (listTahun.data != undefined)
	        	setDropdown(listTahun.data, id, label, $default);

	    } catch (error) {
	        console.error('Something went wrong:', error);
	    }
	})();
}

const getJurusanByCabang = async (id, tahun, cabang, label = '- Pilih -', $default = null) => {
	(async () => {
	    try {
	        // GET Request Example
	        const listJurusans = await fetchData(`${ baseUrl }api/list-dropdown/jurusan-cabang/${ src }`, 'GET', {tahun, cabang});

	        if (listJurusans.data != undefined)
	        	setDropdown(listJurusans.data, id, label, $default);

	    } catch (error) {
	        console.error('Something went wrong:', error);
	    }
	})();
}
