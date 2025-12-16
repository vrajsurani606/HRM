@props([
    'stateValue' => null,
    'cityValue' => null,
    'stateRequired' => false,
    'cityRequired' => false,
    'stateError' => null,
    'cityError' => null,
    'stateClass' => 'Rectangle-29-select',
    'cityClass' => 'Rectangle-29-select',
    'stateOtherValue' => null,
    'cityOtherValue' => null
])

{{-- State Dropdown --}}
<select name="state" id="state_select" class="{{ $stateClass }} @if($stateError) is-invalid @endif" @if($stateRequired) required @endif>
    <option value="" disabled {{ $stateValue ? '' : 'selected' }}>SELECT STATE</option>
    
    {{-- States --}}
    <option value="andhra_pradesh" {{ $stateValue == 'andhra_pradesh' ? 'selected' : '' }}>Andhra Pradesh</option>
    <option value="arunachal_pradesh" {{ $stateValue == 'arunachal_pradesh' ? 'selected' : '' }}>Arunachal Pradesh</option>
    <option value="assam" {{ $stateValue == 'assam' ? 'selected' : '' }}>Assam</option>
    <option value="bihar" {{ $stateValue == 'bihar' ? 'selected' : '' }}>Bihar</option>
    <option value="chhattisgarh" {{ $stateValue == 'chhattisgarh' ? 'selected' : '' }}>Chhattisgarh</option>
    <option value="delhi" {{ $stateValue == 'delhi' ? 'selected' : '' }}>Delhi</option>
    <option value="goa" {{ $stateValue == 'goa' ? 'selected' : '' }}>Goa</option>
    <option value="gujarat" {{ $stateValue == 'gujarat' ? 'selected' : '' }}>Gujarat</option>
    <option value="haryana" {{ $stateValue == 'haryana' ? 'selected' : '' }}>Haryana</option>
    <option value="himachal_pradesh" {{ $stateValue == 'himachal_pradesh' ? 'selected' : '' }}>Himachal Pradesh</option>
    <option value="jammu_kashmir" {{ $stateValue == 'jammu_kashmir' ? 'selected' : '' }}>Jammu & Kashmir</option>
    <option value="jharkhand" {{ $stateValue == 'jharkhand' ? 'selected' : '' }}>Jharkhand</option>
    <option value="karnataka" {{ $stateValue == 'karnataka' ? 'selected' : '' }}>Karnataka</option>
    <option value="kerala" {{ $stateValue == 'kerala' ? 'selected' : '' }}>Kerala</option>
    <option value="ladakh" {{ $stateValue == 'ladakh' ? 'selected' : '' }}>Ladakh</option>
    <option value="madhya_pradesh" {{ $stateValue == 'madhya_pradesh' ? 'selected' : '' }}>Madhya Pradesh</option>
    <option value="maharashtra" {{ $stateValue == 'maharashtra' ? 'selected' : '' }}>Maharashtra</option>
    <option value="manipur" {{ $stateValue == 'manipur' ? 'selected' : '' }}>Manipur</option>
    <option value="meghalaya" {{ $stateValue == 'meghalaya' ? 'selected' : '' }}>Meghalaya</option>
    <option value="mizoram" {{ $stateValue == 'mizoram' ? 'selected' : '' }}>Mizoram</option>
    <option value="nagaland" {{ $stateValue == 'nagaland' ? 'selected' : '' }}>Nagaland</option>
    <option value="odisha" {{ $stateValue == 'odisha' ? 'selected' : '' }}>Odisha</option>
    <option value="punjab" {{ $stateValue == 'punjab' ? 'selected' : '' }}>Punjab</option>
    <option value="rajasthan" {{ $stateValue == 'rajasthan' ? 'selected' : '' }}>Rajasthan</option>
    <option value="sikkim" {{ $stateValue == 'sikkim' ? 'selected' : '' }}>Sikkim</option>
    <option value="tamil_nadu" {{ $stateValue == 'tamil_nadu' ? 'selected' : '' }}>Tamil Nadu</option>
    <option value="telangana" {{ $stateValue == 'telangana' ? 'selected' : '' }}>Telangana</option>
    <option value="tripura" {{ $stateValue == 'tripura' ? 'selected' : '' }}>Tripura</option>
    <option value="uttar_pradesh" {{ $stateValue == 'uttar_pradesh' ? 'selected' : '' }}>Uttar Pradesh</option>
    <option value="uttarakhand" {{ $stateValue == 'uttarakhand' ? 'selected' : '' }}>Uttarakhand</option>
    <option value="west_bengal" {{ $stateValue == 'west_bengal' ? 'selected' : '' }}>West Bengal</option>

    
    {{-- Union Territories --}}
    <option value="andaman_nicobar" {{ $stateValue == 'andaman_nicobar' ? 'selected' : '' }}>Andaman & Nicobar Islands</option>
    <option value="chandigarh" {{ $stateValue == 'chandigarh' ? 'selected' : '' }}>Chandigarh</option>
    <option value="dadra_nagar_haveli_daman_diu" {{ $stateValue == 'dadra_nagar_haveli_daman_diu' ? 'selected' : '' }}>Dadra & Nagar Haveli and Daman & Diu</option>
    <option value="lakshadweep" {{ $stateValue == 'lakshadweep' ? 'selected' : '' }}>Lakshadweep</option>
    <option value="puducherry" {{ $stateValue == 'puducherry' ? 'selected' : '' }}>Puducherry</option>
    
    <option value="other" {{ $stateValue == 'other' ? 'selected' : '' }}>Other</option>
</select>
@if($stateError)
    <small class="hrp-error">{{ $stateError }}</small>
@endif

{{-- Other State Text Input (shown when "Other" is selected) --}}
<input type="text" name="state_other" id="state_other_input" class="{{ $stateClass }}" placeholder="Enter State Name" value="{{ $stateOtherValue }}" style="display: {{ $stateValue == 'other' ? 'block' : 'none' }}; margin-top: 8px;">