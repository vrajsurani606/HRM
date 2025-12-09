// State-City Dropdown Data for All Indian States and Union Territories
const stateCityData = {
    'andhra_pradesh': [
        'Visakhapatnam', 'Vijayawada', 'Guntur', 'Nellore', 'Kurnool', 'Tirupati', 'Rajahmundry', 
        'Kakinada', 'Anantapur', 'Kadapa', 'Eluru', 'Ongole', 'Nandyal', 'Machilipatnam', 
        'Adoni', 'Tenali', 'Chittoor', 'Hindupur', 'Proddatur', 'Bhimavaram', 'Madanapalle', 
        'Guntakal', 'Dharmavaram', 'Gudivada', 'Srikakulam', 'Narasaraopet', 'Tadipatri', 
        'Tadepalligudem', 'Chilakaluripet', 'Other'
    ],
    'arunachal_pradesh': [
        'Itanagar', 'Naharlagun', 'Pasighat', 'Tawang', 'Ziro', 'Bomdila', 'Tezu', 'Seppa', 
        'Along', 'Anini', 'Changlang', 'Daporijo', 'Khonsa', 'Roing', 'Tuting', 'Other'
    ],
    'assam': [
        'Guwahati', 'Silchar', 'Dibrugarh', 'Jorhat', 'Nagaon', 'Tinsukia', 'Tezpur', 
        'Bongaigaon', 'Diphu', 'Dhubri', 'Goalpara', 'Barpeta', 'Karimganj', 'Sivasagar', 
        'Golaghat', 'Haflong', 'Hojai', 'Mangaldoi', 'North Lakhimpur', 'Kokrajhar', 
        'Hailakandi', 'Morigaon', 'Nalbari', 'Rangia', 'Sibsagar', 'Other'
    ],
    'bihar': [
        'Patna', 'Gaya', 'Bhagalpur', 'Muzaffarpur', 'Purnia', 'Darbhanga', 'Bihar Sharif', 
        'Arrah', 'Begusarai', 'Katihar', 'Munger', 'Chhapra', 'Danapur', 'Bettiah', 'Saharsa', 
        'Hajipur', 'Sasaram', 'Dehri', 'Siwan', 'Motihari', 'Nawada', 'Bagaha', 'Buxar', 
        'Kishanganj', 'Sitamarhi', 'Jamalpur', 'Jehanabad', 'Aurangabad', 'Other'
    ],
    'chhattisgarh': [
        'Raipur', 'Bhilai', 'Bilaspur', 'Korba', 'Durg', 'Rajnandgaon', 'Raigarh', 'Jagdalpur', 
        'Ambikapur', 'Chirmiri', 'Dhamtari', 'Mahasamund', 'Kawardha', 'Bhatapara', 'Dalli-Rajhara', 
        'Naila Janjgir', 'Tilda Newra', 'Mungeli', 'Manendragarh', 'Sakti', 'Other'
    ],
    'delhi': [
        'New Delhi', 'Delhi', 'Noida', 'Gurgaon', 'Faridabad', 'Ghaziabad', 'Greater Noida', 
        'Dwarka', 'Rohini', 'Janakpuri', 'Laxmi Nagar', 'Karol Bagh', 'Connaught Place', 
        'Saket', 'Vasant Kunj', 'Nehru Place', 'Pitampura', 'Mayur Vihar', 'Preet Vihar', 
        'Shahdara', 'Other'
    ],
    'goa': [
        'Panaji', 'Margao', 'Vasco da Gama', 'Mapusa', 'Ponda', 'Bicholim', 'Curchorem', 
        'Sanquelim', 'Cuncolim', 'Quepem', 'Canacona', 'Pernem', 'Valpoi', 'Sanguem', 'Other'
    ],
    'gujarat': [
        'Ahmedabad', 'Surat', 'Vadodara', 'Rajkot', 'Bhavnagar', 'Jamnagar', 'Junagadh', 
        'Gandhinagar', 'Anand', 'Nadiad', 'Morbi', 'Mehsana', 'Bharuch', 'Vapi', 'Navsari', 
        'Veraval', 'Porbandar', 'Godhra', 'Palanpur', 'Valsad', 'Patan', 'Deesa', 'Amreli', 
        'Surendranagar', 'Bhuj', 'Gandhidham', 'Ankleshwar', 'Botad', 'Dahod', 'Kalol', 
        'Khambhat', 'Mahuva', 'Modasa', 'Petlad', 'Visnagar', 'Wadhwan', 'Other'
    ],
    'haryana': [
        'Faridabad', 'Gurgaon', 'Panipat', 'Ambala', 'Yamunanagar', 'Rohtak', 'Hisar', 'Karnal', 
        'Sonipat', 'Panchkula', 'Bhiwani', 'Sirsa', 'Bahadurgarh', 'Jind', 'Thanesar', 'Kaithal', 
        'Rewari', 'Palwal', 'Pundri', 'Kosli', 'Narnaul', 'Fatehabad', 'Gohana', 'Tohana', 
        'Narwana', 'Mandi Dabwali', 'Charkhi Dadri', 'Shahbad', 'Pehowa', 'Samalkha', 'Other'
    ],
    'himachal_pradesh': [
        'Shimla', 'Mandi', 'Solan', 'Dharamshala', 'Kullu', 'Manali', 'Palampur', 'Baddi', 
        'Nahan', 'Paonta Sahib', 'Sundarnagar', 'Chamba', 'Una', 'Hamirpur', 'Bilaspur', 
        'Yol', 'Nalagarh', 'Nurpur', 'Kangra', 'Santokhgarh', 'Mehatpur', 'Shamshi', 'Parwanoo', 
        'Rampur', 'Rohru', 'Other'
    ],
    'jammu_kashmir': [
        'Srinagar', 'Jammu', 'Anantnag', 'Baramulla', 'Sopore', 'Kathua', 'Udhampur', 'Punch', 
        'Rajauri', 'Kupwara', 'Bandipore', 'Ganderbal', 'Kulgam', 'Pulwama', 'Shopian', 
        'Budgam', 'Doda', 'Kishtwar', 'Ramban', 'Reasi', 'Samba', 'Other'
    ],
    'jharkhand': [
        'Ranchi', 'Jamshedpur', 'Dhanbad', 'Bokaro', 'Deoghar', 'Hazaribagh', 'Giridih', 
        'Ramgarh', 'Medininagar', 'Chirkunda', 'Phusro', 'Adityapur', 'Saunda', 'Sahibganj', 
        'Madhupur', 'Chaibasa', 'Chatra', 'Gumla', 'Dumka', 'Godda', 'Koderma', 'Mihijam', 
        'Pakaur', 'Patratu', 'Rajmahal', 'Simdega', 'Tenughat', 'Other'
    ],
    'karnataka': [
        'Bengaluru', 'Mysuru', 'Hubli', 'Mangaluru', 'Belgaum', 'Gulbarga', 'Davanagere', 
        'Bellary', 'Shimoga', 'Tumkur', 'Raichur', 'Bidar', 'Hospet', 'Hassan', 'Gadag-Betigeri', 
        'Udupi', 'Robertson Pet', 'Bhadravati', 'Chitradurga', 'Kolar', 'Mandya', 'Chikmagalur', 
        'Gangavati', 'Bagalkot', 'Ranebennuru', 'Other'
    ],
    'kerala': [
        'Thiruvananthapuram', 'Kochi', 'Kozhikode', 'Thrissur', 'Kollam', 'Kannur', 'Alappuzha', 
        'Palakkad', 'Malappuram', 'Kottayam', 'Kasaragod', 'Pathanamthitta', 'Idukki', 'Wayanad', 
        'Ernakulam', 'Thalassery', 'Ponnani', 'Vatakara', 'Kanhangad', 'Payyanur', 'Koyilandy', 
        'Parappanangadi', 'Kalamassery', 'Neyyattinkara', 'Tanur', 'Kayamkulam', 'Thrippunithura', 
        'Muvattupuzha', 'Kothamangalam', 'Pathanapuram', 'Other'
    ],
    'madhya_pradesh': [
        'Indore', 'Bhopal', 'Jabalpur', 'Gwalior', 'Ujjain', 'Sagar', 'Dewas', 'Satna', 'Ratlam', 
        'Rewa', 'Murwara', 'Singrauli', 'Burhanpur', 'Khandwa', 'Morena', 'Bhind', 'Chhindwara', 
        'Guna', 'Shivpuri', 'Vidisha', 'Chhatarpur', 'Damoh', 'Mandsaur', 'Khargone', 'Neemuch', 
        'Pithampur', 'Hoshangabad', 'Itarsi', 'Sehore', 'Betul', 'Seoni', 'Datia', 'Nagda', 
        'Dhar', 'Other'
    ],
    'maharashtra': [
        'Mumbai', 'Pune', 'Nagpur', 'Thane', 'Nashik', 'Aurangabad', 'Solapur', 'Kolhapur', 
        'Navi Mumbai', 'Amravati', 'Sangli', 'Malegaon', 'Jalgaon', 'Akola', 'Latur', 'Ahmednagar', 
        'Dhule', 'Ichalkaranji', 'Chandrapur', 'Parbhani', 'Jalna', 'Bhusawal', 'Nanded', 'Satara', 
        'Beed', 'Yavatmal', 'Kamptee', 'Gondia', 'Barshi', 'Achalpur', 'Osmanabad', 'Nandurbar', 
        'Wardha', 'Udgir', 'Hinganghat', 'Other'
    ],
    'manipur': [
        'Imphal', 'Thoubal', 'Bishnupur', 'Churachandpur', 'Senapati', 'Ukhrul', 'Chandel', 
        'Tamenglong', 'Jiribam', 'Kakching', 'Moirang', 'Mayang Imphal', 'Yairipok', 'Other'
    ],
    'meghalaya': [
        'Shillong', 'Tura', 'Nongstoin', 'Jowai', 'Baghmara', 'Williamnagar', 'Nongpoh', 
        'Mairang', 'Resubelpara', 'Ampati', 'Cherrapunji', 'Mawlai', 'Other'
    ],
    'mizoram': [
        'Aizawl', 'Lunglei', 'Champhai', 'Serchhip', 'Kolasib', 'Lawngtlai', 'Saiha', 'Mamit', 
        'Khawzawl', 'Hnahthial', 'Saitual', 'Other'
    ],
    'nagaland': [
        'Kohima', 'Dimapur', 'Mokokchung', 'Tuensang', 'Wokha', 'Zunheboto', 'Phek', 'Mon', 
        'Longleng', 'Kiphire', 'Peren', 'Other'
    ],
    'odisha': [
        'Bhubaneswar', 'Cuttack', 'Rourkela', 'Berhampur', 'Sambalpur', 'Puri', 'Balasore', 
        'Bhadrak', 'Baripada', 'Jharsuguda', 'Jeypore', 'Bargarh', 'Balangir', 'Rayagada', 
        'Bhawanipatna', 'Dhenkanal', 'Barbil', 'Kendujhar', 'Sunabeda', 'Jatani', 'Byasanagar', 
        'Paradip', 'Talcher', 'Nabarangpur', 'Phulbani', 'Other'
    ],
    'punjab': [
        'Ludhiana', 'Amritsar', 'Jalandhar', 'Patiala', 'Bathinda', 'Mohali', 'Pathankot', 
        'Hoshiarpur', 'Batala', 'Moga', 'Malerkotla', 'Khanna', 'Phagwara', 'Muktsar', 'Barnala', 
        'Rajpura', 'Firozpur', 'Kapurthala', 'Faridkot', 'Sunam', 'Jagraon', 'Abohar', 'Fazilka', 
        'Mansa', 'Sangrur', 'Nabha', 'Tarn Taran', 'Gurdaspur', 'Kharar', 'Gobindgarh', 
        'Mandi Gobindgarh', 'Malout', 'Nangal', 'Morinda', 'Phillaur', 'Other'
    ],
    'rajasthan': [
        'Jaipur', 'Jodhpur', 'Kota', 'Bikaner', 'Ajmer', 'Udaipur', 'Bhilwara', 'Alwar', 
        'Bharatpur', 'Sikar', 'Pali', 'Sri Ganganagar', 'Kishangarh', 'Tonk', 'Beawar', 'Hanumangarh', 
        'Gangapur City', 'Churu', 'Dhaulpur', 'Sawai Madhopur', 'Jhunjhunu', 'Barmer', 'Nagaur', 
        'Chittorgarh', 'Makrana', 'Sujangarh', 'Sardarshahar', 'Ladnu', 'Ratangarh', 'Nokha', 
        'Nimbahera', 'Suratgarh', 'Rajsamand', 'Lachhmangarh', 'Rajgarh', 'Nasirabad', 'Nohar', 
        'Phalodi', 'Nathdwara', 'Pilani', 'Merta City', 'Other'
    ],
    'sikkim': [
        'Gangtok', 'Namchi', 'Gyalshing', 'Mangan', 'Rangpo', 'Jorethang', 'Singtam', 'Ravangla', 
        'Pelling', 'Yuksom', 'Other'
    ],
    'tamil_nadu': [
        'Chennai', 'Coimbatore', 'Madurai', 'Tiruchirappalli', 'Salem', 'Tirunelveli', 'Tiruppur', 
        'Erode', 'Vellore', 'Thoothukudi', 'Thanjavur', 'Dindigul', 'Ranipet', 'Sivakasi', 
        'Karur', 'Udhagamandalam', 'Hosur', 'Nagercoil', 'Kanchipuram', 'Kumarapalayam', 
        'Karaikkudi', 'Neyveli', 'Cuddalore', 'Kumbakonam', 'Tiruvannamalai', 'Pollachi', 
        'Rajapalayam', 'Gudiyatham', 'Pudukkottai', 'Vaniyambadi', 'Ambur', 'Nagapattinam', 
        'Other'
    ],
    'telangana': [
        'Hyderabad', 'Warangal', 'Nizamabad', 'Karimnagar', 'Khammam', 'Ramagundam', 'Secunderabad', 
        'Mahbubnagar', 'Nalgonda', 'Adilabad', 'Suryapet', 'Siddipet', 'Miryalaguda', 'Jagtial', 
        'Mancherial', 'Nirmal', 'Kothagudem', 'Bodhan', 'Palwancha', 'Mandamarri', 'Koratla', 
        'Sircilla', 'Tandur', 'Sathupally', 'Wanaparthy', 'Kagaznagar', 'Gadwal', 'Sangareddy', 
        'Bellampalle', 'Bhongir', 'Vikarabad', 'Jangaon', 'Bhadrachalam', 'Bhainsa', 'Farooqnagar', 
        'Medak', 'Other'
    ],
    'tripura': [
        'Agartala', 'Dharmanagar', 'Udaipur', 'Kailasahar', 'Belonia', 'Khowai', 'Ambassa', 
        'Ranir Bazar', 'Sonamura', 'Sabroom', 'Amarpur', 'Teliamura', 'Kamalpur', 'Other'
    ],
    'uttar_pradesh': [
        'Lucknow', 'Kanpur', 'Ghaziabad', 'Agra', 'Meerut', 'Varanasi', 'Prayagraj', 'Bareilly', 
        'Aligarh', 'Moradabad', 'Saharanpur', 'Gorakhpur', 'Noida', 'Firozabad', 'Jhansi', 
        'Muzaffarnagar', 'Mathura', 'Rampur', 'Shahjahanpur', 'Farrukhabad', 'Maunath Bhanjan', 
        'Hapur', 'Ayodhya', 'Etawah', 'Mirzapur', 'Bulandshahr', 'Sambhal', 'Amroha', 'Hardoi', 
        'Fatehpur', 'Raebareli', 'Orai', 'Sitapur', 'Bahraich', 'Modinagar', 'Unnao', 'Jaunpur', 
        'Lakhimpur', 'Hathras', 'Banda', 'Pilibhit', 'Barabanki', 'Khurja', 'Gonda', 'Mainpuri', 
        'Lalitpur', 'Etah', 'Deoria', 'Ujhani', 'Ghazipur', 'Sultanpur', 'Azamgarh', 'Bijnor', 
        'Sahaswan', 'Basti', 'Chandausi', 'Akbarpur', 'Ballia', 'Tanda', 'Greater Noida', 
        'Shikohabad', 'Shamli', 'Awagarh', 'Kasganj', 'Other'
    ],
    'uttarakhand': [
        'Dehradun', 'Haridwar', 'Roorkee', 'Haldwani', 'Rudrapur', 'Kashipur', 'Rishikesh', 
        'Pithoragarh', 'Jaspur', 'Almora', 'Baraut', 'Manglaur', 'Laksar', 'Pauri', 'Nainital', 
        'Mussoorie', 'Tehri', 'Bageshwar', 'Champawat', 'Rudraprayag', 'Uttarkashi', 'Kotdwar', 
        'Ramnagar', 'Sitarganj', 'Kichha', 'Tanakpur', 'Bazpur', 'Other'
    ],
    'west_bengal': [
        'Kolkata', 'Howrah', 'Durgapur', 'Asansol', 'Siliguri', 'Bardhaman', 'Malda', 'Kharagpur', 
        'Baharampur', 'Habra', 'Raiganj', 'Jalpaiguri', 'Santipur', 'Balurghat', 'Medinipur', 
        'Bankura', 'Nabadwip', 'Darjeeling', 'Purulia', 'Haldia', 'Nadia', 'Murshidabad', 
        'Birbhum', 'Cooch Behar', 'Alipurduar', 'Krishnanagar', 'Ranaghat', 'Bongaon', 'Barrackpore', 
        'Serampore', 'Chandannagar', 'Bhatpara', 'Barasat', 'Rajarhat', 'Dum Dum', 'Rishra', 
        'Titagarh', 'Madhyamgram', 'Uttarpara', 'Kanchrapara', 'Bally', 'Naihati', 'Panihati', 
        'Kamarhati', 'Other'
    ],
    'other': [
        'Other'
    ]
};

/**
 * Populate cities dropdown based on selected state
 * @param {string} stateValue - The selected state value
 * @param {string|null} selectedCity - The city to be pre-selected (optional)
 */
function populateCities(stateValue, selectedCity = null) {
    const citySelect = document.getElementById('city_select');
    const cityManualInput = document.getElementById('city_manual_input');
    
    if (!citySelect) return;
    
    // Clear existing options
    citySelect.innerHTML = '<option value="" disabled selected>SELECT CITY</option>';
    
    // Hide manual input by default
    if (cityManualInput) {
        cityManualInput.style.display = 'none';
        cityManualInput.value = '';
    }
    
    // Populate cities if state is selected
    if (stateValue && stateCityData[stateValue]) {
        const cities = stateCityData[stateValue];
        cities.forEach(city => {
            const option = document.createElement('option');
            option.value = city.toLowerCase().replace(/\s+/g, '_');
            option.textContent = city;
            if (selectedCity && option.value === selectedCity) {
                option.selected = true;
                // If "Other" is selected, show manual input
                if (city === 'Other' && cityManualInput) {
                    cityManualInput.style.display = 'block';
                }
            }
            citySelect.appendChild(option);
        });
    } else {
        citySelect.innerHTML = '<option value="" disabled selected>SELECT STATE FIRST</option>';
    }
}

/**
 * Handle city selection change - show/hide manual input for "Other"
 */
function handleCityChange() {
    const citySelect = document.getElementById('city_select');
    const cityManualInput = document.getElementById('city_manual_input');
    
    if (!citySelect || !cityManualInput) return;
    
    const selectedOption = citySelect.options[citySelect.selectedIndex];
    
    if (selectedOption && selectedOption.textContent === 'Other') {
        cityManualInput.style.display = 'block';
        cityManualInput.required = true;
        cityManualInput.focus();
    } else {
        cityManualInput.style.display = 'none';
        cityManualInput.required = false;
        cityManualInput.value = '';
    }
}

/**
 * Initialize state-city dropdown functionality
 */
function initializeStateCityDropdown() {
    const stateSelect = document.getElementById('state_select');
    const citySelect = document.getElementById('city_select');
    const oldCity = document.getElementById('old_city')?.value;
    
    if (!stateSelect || !citySelect) return;
    
    // If state is already selected (e.g., from old input or edit form), populate cities
    if (stateSelect.value) {
        populateCities(stateSelect.value, oldCity || citySelect.dataset.selectedCity);
    }
    
    // Add change event listener to state dropdown
    stateSelect.addEventListener('change', function() {
        populateCities(this.value);
    });
    
    // Add change event listener to city dropdown
    citySelect.addEventListener('change', handleCityChange);
    
    // Check if "Other" is already selected on page load
    handleCityChange();
}

// Initialize on DOM ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initializeStateCityDropdown);
} else {
    initializeStateCityDropdown();
}
