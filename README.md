# flip-disbursement-ex

### Run
1. Update `conf.ini` according to your own mysqldb config.
2. Run the server: `php -S localhost:7000`, or using other port.
3. Access the API

### Migrate
1. Make sure the content of `conf.ini` already valid for your own mysqldb.
2. Migrate the db: `php migrate.php`

### API
Base url: `http://localhost:7000` (change the port if you run the app in other port)
#### New Transaction
`POST /transaction`
Request example:
```
bank_code:bri
account_number:1231234
amount:1000000
remark:sample
```
Response example:
```
{
    "id": 3,
    "bank_code": "bri",
    "account_number": "1231234",
    "fee": 4000,
    "amount": "1000000",
    "remark": "sample",
    "status": "PENDING",
    "receipt": null,
    "time_served": null,
    "beneficiary_name": "PT FLIP",
    "flip_trans_id": 7843345063,
    "created_at": "2020-01-22 05:14:11",
    "updated_at": "2020-01-22 05:14:11"
}
```

#### Get (Check) Transaction
`GET /transaction?id_transaction=<Transaction ID>`
Response Example:
```
{
    "id": "2",
    "bank_code": "bri",
    "account_number": "123123",
    "fee": "4000",
    "amount": "1000000",
    "remark": "sample",
    "status": "SUCCESS",
    "receipt": "https://flip-receipt.oss-ap-southeast-5.aliyuncs.com/debit_receipt/126316_3d07f9fef9612c7275b3c36f7e1e5762.jpg",
    "time_served": "2020-01-22 12:20:21",
    "beneficiary_name": "PT FLIP",
    "flip_trans_id": "6047156561",
    "created_at": "2020-01-22 04:54:25",
    "updated_at": "2020-01-22 05:21:18"
}
```
