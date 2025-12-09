// State-City Dropdown Data for Indian States
const stateCityData = {
    'andhra_pradesh': [
        {value: 'visakhapatnam', label: 'Visakhapatnam'},
        {value: 'vijayawada', label: 'Vijayawada'},
        {value: 'guntur', label: 'Guntur'},
        {value: 'nellore', label: 'Nellore'},
        {value: 'kurnool', label: 'Kurnool'},
        {value: 'tirupati', label: 'Tirupati'},
        {value: 'rajahmundry', label: 'Rajahmundry'},
        {value: 'kakinada', label: 'Kakinada'},
        {value: 'anantapur', label: 'Anantapur'},
        {value: 'other', label: 'Other'}
    ],
    'arunachal_pradesh': [
        {value: 'itanagar', label: 'Itanagar'},
        {value: 'naharlagun', label: 'Naharlagun'},
        {value: 'pasighat', label: 'Pasighat'},
        {value: 'other', label: 'Other'}
    ],
    'assam': [
        {value: 'guwahati', label: 'Guwahati'},
        {value: 'silchar', label: 'Silchar'},
        {value: 'dibrugarh', label: 'Dibrugarh'},
        {value: 'jorhat', label: 'Jorhat'},
        {value: 'nagaon', label: 'Nagaon'},
        {value: 'tinsukia', label: 'Tinsukia'},
        {value: 'other', label: 'Other'}
    ],
    'bihar': [
        {value: 'patna', label: 'Patna'},
        {value: 'gaya', label: 'Gaya'},
        {value: 'bhagalpur', label: 'Bhagalpur'},
        {value: 'muzaffarpur', label: 'Muzaffarpur'},
        {value: 'purnia', label: 'Purnia'},
        {value: 'darbhanga', label: 'Darbhanga'},
        {value: 'bihar_sharif', label: 'Bihar Sharif'},
        {value: 'other', label: 'Other'}
    ],
    'chhattisgarh': [
        {value: 'raipur', label: 'Raipur'},
        {value: 'bhilai', label: 'Bhilai'},
        {value: 'bilaspur', label: 'Bilaspur'},
        {value: 'korba', label: 'Korba'},
        {value: 'durg', label: 'Durg'},
        {value: 'rajnandgaon', label: 'Rajnandgaon'},
        {value: 'other', label: 'Other'}
    ],
    'delhi': [
        {value: 'new_delhi', label: 'New Delhi'},
        {value: 'delhi', label: 'Delhi'},
        {value: 'noida', label: 'Noida'},
        {value: 'gurgaon', label: 'Gurgaon'},
        {value: 'faridabad', label: 'Faridabad'},
        {value: 'ghaziabad', label: 'Ghaziabad'},
        {value: 'other', label: 'Other'}
    ],
    'goa': [
        {value: 'panaji', label: 'Panaji'},
        {value: 'margao', label: 'Margao'},
        {value: 'vasco_da_gama', label: 'Vasco da Gama'},
        {value: 'mapusa', label: 'Mapusa'},
        {value: 'ponda', label: 'Ponda'},
        {value: 'other', label: 'Other'}
    ],
    'gujarat': [
        {value: 'ahmedabad', label: 'Ahmedabad'},
        {value: 'surat', label: 'Surat'},
        {value: 'vadodara', label: 'Vadodara'},
        {value: 'rajkot', label: 'Rajkot'},
        {value: 'bhavnagar', label: 'Bhavnagar'},
        {value: 'jamnagar', label: 'Jamnagar'},
        {value: 'junagadh', label: 'Junagadh'},
        {value: 'gandhinagar', label: 'Gandhinagar'},
        {value: 'anand', label: 'Anand'},
        {value: 'nadiad', label: 'Nadiad'},
        {value: 'morbi', label: 'Morbi'},
        {value: 'mehsana', label: 'Mehsana'},
        {value: 'bharuch', label: 'Bharuch'},
        {value: 'vapi', label: 'Vapi'},
        {value: 'navsari', label: 'Navsari'},
        {value: 'veraval', label: 'Veraval'},
        {value: 'porbandar', label: 'Porbandar'},
        {value: 'godhra', label: 'Godhra'},
        {value: 'palanpur', label: 'Palanpur'},
        {value: 'valsad', label: 'Valsad'},
        {value: 'other', label: 'Other'}
    ],
    'haryana': [
        {value: 'faridabad', label: 'Faridabad'},
        {value: 'gurgaon', label: 'Gurgaon'},
        {value: 'panipat', label: 'Panipat'},
        {value: 'ambala', label: 'Ambala'},
        {value: 'yamunanagar', label: 'Yamunanagar'},
        {value: 'rohtak', label: 'Rohtak'},
        {value: 'hisar', label: 'Hisar'},
        {value: 'karnal', label: 'Karnal'},
        {value: 'sonipat', label: 'Sonipat'},
        {value: 'panchkula', label: 'Panchkula'},
        {value: 'other', label: 'Other'}
    ],
    'himachal_pradesh': [
        {value: 'shimla', label: 'Shimla'},
        {value: 'mandi', label: 'Mandi'},
        {value: 'solan', label: 'Solan'},
        {value: 'dharamshala', label: 'Dharamshala'},
        {value: 'kullu', label: 'Kullu'},
        {value: 'manali', label: 'Manali'},
        {value: 'other', label: 'Other'}
    ],
    'jammu_kashmir': [
        {value: 'srinagar', label: 'Srinagar'},
        {value: 'jammu', label: 'Jammu'},
        {value: 'anantnag', label: 'Anantnag'},
        {value: 'baramulla', label: 'Baramulla'},
        {value: 'other', label: 'Other'}
    ],
    'jharkhand': [
        {value: 'ranchi', label: 'Ranchi'},
        {value: 'jamshedpur', label: 'Jamshedpur'},
        {value: 'dhanbad', label: 'Dhanbad'},
        {value: 'bokaro', label: 'Bokaro'},
        {value: 'deoghar', label: 'Deoghar'},
        {value: 'hazaribagh', label: 'Hazaribagh'},
        {value: 'other', label: 'Other'}
    ],
    'karnataka': [
        {value: 'bengaluru', label: 'Bengaluru'},
        {value: 'mysuru', label: 'Mysuru'},
        {value: 'hubli', label: 'Hubli'},
        {value: 'mangaluru', label: 'Mangaluru'},
        {value: 'belgaum', label: 'Belgaum'},
        {value: 'gulbarga', label: 'Gulbarga'},
        {value: 'davanagere', label: 'Davanagere'},
        {value: 'bellary', label: 'Bellary'},
        {value: 'shimoga', label: 'Shimoga'},
        {value: 'tumkur', label: 'Tumkur'},
        {value: 'other', label: 'Other'}
    ],
    'kerala': [
        {value: 'thiruvananthapuram', label: 'Thiruvananthapuram'},
        {value: 'kochi', label: 'Kochi'},
        {value: 'kozhikode', label: 'Kozhikode'},
        {value: 'thrissur', label: 'Thrissur'},
        {value: 'kollam', label: 'Kollam'},
        {value: 'kannur', label: 'Kannur'},
        {value: 'alappuzha', label: 'Alappuzha'},
        {value: 'palakkad', label: 'Palakkad'},
        {value: 'other', label: 'Other'}
    ],
    'madhya_pradesh': [
        {value: 'indore', label: 'Indore'},
        {value: 'bhopal', label: 'Bhopal'},
        {value: 'jabalpur', label: 'Jabalpur'},
        {value: 'gwalior', label: 'Gwalior'},
        {value: 'ujjain', label: 'Ujjain'},
        {value: 'sagar', label: 'Sagar'},
        {value: 'dewas', label: 'Dewas'},
        {value: 'satna', label: 'Satna'},
        {value: 'ratlam', label: 'Ratlam'},
        {value: 'other', label: 'Other'}
    ],
    'maharashtra': [
        {value: 'mumbai', label: 'Mumbai'},
        {value: 'pune', label: 'Pune'},
        {value: 'nagpur', label: 'Nagpur'},
        {value: 'thane', label: 'Thane'},
        {value: 'nashik', label: 'Nashik'},
        {value: 'aurangabad', label: 'Aurangabad'},
        {value: 'solapur', label: 'Solapur'},
        {value: 'kolhapur', label: 'Kolhapur'},
        {value: 'navi_mumbai', label: 'Navi Mumbai'},
        {value: 'amravati', label: 'Amravati'},
        {value: 'sangli', label: 'Sangli'},
        {value: 'malegaon', label: 'Malegaon'},
        {value: 'jalgaon', label: 'Jalgaon'},
        {value: 'akola', label: 'Akola'},
        {value: 'latur', label: 'Latur'},
        {value: 'ahmednagar', label: 'Ahmednagar'},
        {value: 'other', label: 'Other'}
    ],
    'manipur': [
        {value: 'imphal', label: 'Imphal'},
        {value: 'thoubal', label: 'Thoubal'},
        {value: 'other', label: 'Other'}
    ],
    'meghalaya': [
        {value: 'shillong', label: 'Shillong'},
        {value: 'tura', label: 'Tura'},
        {value: 'other', label: 'Other'}
    ],
    'mizoram': [
        {value: 'aizawl', label: 'Aizawl'},
        {value: 'lunglei', label: 'Lunglei'},
        {value: 'other', label: 'Other'}
    ],
    'nagaland': [
        {value: 'kohima', label: 'Kohima'},
        {value: 'dimapur', label: 'Dimapur'},
        {value: 'other', label: 'Other'}
    ],
    'odisha': [
        {value: 'bhubaneswar', label: 'Bhubaneswar'},
        {value: 'cuttack', label: 'Cuttack'},
        {value: 'rourkela', label: 'Rourkela'},
        {value: 'berhampur', label: 'Berhampur'},
        {value: 'sambalpur', label: 'Sambalpur'},
        {value: 'puri', label: 'Puri'},
        {value: 'other', label: 'Other'}
    ],
    'punjab': [
        {value: 'ludhiana', label: 'Ludhiana'},
        {value: 'amritsar', label: 'Amritsar'},
        {value: 'jalandhar', label: 'Jalandhar'},
        {value: 'patiala', label: 'Patiala'},
        {value: 'bathinda', label: 'Bathinda'},
        {value: 'mohali', label: 'Mohali'},
        {value: 'pathankot', label: 'Pathankot'},
        {value: 'hoshiarpur', label: 'Hoshiarpur'},
        {value: 'other', label: 'Other'}
    ],
    'rajasthan': [
        {value: 'jaipur', label: 'Jaipur'},
        {value: 'jodhpur', label: 'Jodhpur'},
        {value: 'kota', label: 'Kota'},
        {value: 'bikaner', label: 'Bikaner'},
        {value: 'ajmer', label: 'Ajmer'},
        {value: 'udaipur', label: 'Udaipur'},
        {value: 'bhilwara', label: 'Bhilwara'},
        {value: 'alwar', label: 'Alwar'},
        {value: 'bharatpur', label: 'Bharatpur'},
        {value: 'sikar', label: 'Sikar'},
        {value: 'other', label: 'Other'}
    ],
    'sikkim': [
        {value: 'gangtok', label: 'Gangtok'},
        {value: 'namchi', label: 'Namchi'},
        {value: 'other', label: 'Other'}
    ],
    'tamil_nadu': [
        {value: 'chennai', label: 'Chennai'},
        {value: 'coimbatore', label: 'Coimbatore'},
        {value: 'madurai', label: 'Madurai'},
        {value: 'tiruchirappalli', label: 'Tiruchirappalli'},
        {value: 'salem', label: 'Salem'},
        {value: 'tirunelveli', label: 'Tirunelveli'},
        {value: 'tiruppur', label: 'Tiruppur'},
        {value: 'erode', label: 'Erode'},
        {value: 'vellore', label: 'Vellore'},
        {value: 'thoothukudi', label: 'Thoothukudi'},
        {value: 'other', label: 'Other'}
    ],
    'telangana': [
        {value: 'hyderabad', label: 'Hyderabad'},
        {value: 'warangal', label: 'Warangal'},
        {value: 'nizamabad', label: 'Nizamabad'},
        {value: 'karimnagar', label: 'Karimnagar'},
        {value: 'khammam', label: 'Khammam'},
        {value: 'ramagundam', label: 'Ramagundam'},
        {value: 'secunderabad', label: 'Secunderabad'},
        {value: 'other', label: 'Other'}
    ],
    'tripura': [
        {value: 'agartala', label: 'Agartala'},
        {value: 'other', label: 'Other'}
    ],
    'uttar_pradesh': [
        {value: 'lucknow', label: 'Lucknow'},
        {value: 'kanpur', label: 'Kanpur'},
        {value: 'ghaziabad', label: 'Ghaziabad'},
        {value: 'agra', label: 'Agra'},
        {value: 'meerut', label: 'Meerut'},
        {value: 'varanasi', label: 'Varanasi'},
        {value: 'prayagraj', label: 'Prayagraj'},
        {value: 'bareilly', label: 'Bareilly'},
        {value: 'aligarh', label: 'Aligarh'},
        {value: 'moradabad', label: 'Moradabad'},
        {value: 'saharanpur', label: 'Saharanpur'},
        {value: 'gorakhpur', label: 'Gorakhpur'},
        {value: 'noida', label: 'Noida'},
        {value: 'firozabad', label: 'Firozabad'},
        {value: 'jhansi', label: 'Jhansi'},
        {value: 'other', label: 'Other'}
    ],
    'uttarakhand': [
        {value: 'dehradun', label: 'Dehradun'},
        {value: 'haridwar', label: 'Haridwar'},
        {value: 'roorkee', label: 'Roorkee'},
        {value: 'haldwani', label: 'Haldwani'},
        {value: 'rudrapur', label: 'Rudrapur'},
        {value: 'kashipur', label: 'Kashipur'},
        {value: 'rishikesh', label: 'Rishikesh'},
        {value: 'other', label: 'Other'}
    ],
    'west_bengal': [
        {value: 'kolkata', label: 'Kolkata'},
        {value: 'howrah', label: 'Howrah'},
        {value: 'durgapur', label: 'Durgapur'},
        {value: 'asansol', label: 'Asansol'},
        {value: 'siliguri', label: 'Siliguri'},
        {value: 'bardhaman', label: 'Bardhaman'},
        {value: 'malda', label: 'Malda'},
        {value: 'kharagpur', label: 'Kharagpur'},
        {value: 'other', label: 'Other'}
    ],
    'other': [
        {value: 'other', label: 'Other'}
    ]
};

/**
 * Populate cities dropdown based on selected state
 * @param {string} stateValue - The selected state value
 * @param {string|null} selectedCity - The city to be pre-selected (optional)
 */
function populateCities(stateValue, selectedCity = null) {
    const citySelect = document.getElementById('city_select');
    if (!citySelect) return;
    
    // Clear existing options
    citySelect.innerHTML = '<option value="" disabled selected>SELECT CITY</option>';
    
    // Populate cities if state is selected
    if (stateValue && stateCityData[stateValue]) {
        const cities = stateCityData[stateValue];
        cities.forEach(city => {
            const option = document.createElement('option');
            option.value = city.value;
            option.textContent = city.label;
            if (selectedCity && city.value === selectedCity) {
                option.selected = true;
            }
            citySelect.appendChild(option);
        });
    } else {
        citySelect.innerHTML = '<option value="" disabled selected>SELECT STATE FIRST</option>';
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
}

// Initialize on DOM ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initializeStateCityDropdown);
} else {
    initializeStateCityDropdown();
}
