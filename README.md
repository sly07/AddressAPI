# AddressAPI

<h3>In order to store new addresses: POST /addresses/add</h3>
- POST body should be in JSON format and include the following parameters: name, street_address, city, state, zip_code

<h3>To get all addresses in the database: POST /addresses/get</h3>

<h3>To lookup addresses by name: POST /addresses/search</h3>
- POST body should be in JSON format and include the following parameter: name

<h3>To lookup addresses by zip code: POST /addresses/search</h3>
- POST body should be in JSON format and include the following parameter: zip_code
