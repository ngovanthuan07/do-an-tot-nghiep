
export async function getByProvince(provinceCode) {
    const url = `/districts/getByProvince/${provinceCode}`;
    const response = await fetch(url, {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
        }
    });
    return response.json();
}
export async function getByDistrict(districtCode) {
    const url = `/wards/getByDistrict/${districtCode}`;
    const response = await fetch(url, {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
        }
    });
    return response.json();
}
