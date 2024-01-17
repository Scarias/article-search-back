<center>
<h1 style="color: #d87ecd;">Article Search API</h1>
</center>

A simple <span style="color: #f03f31;">_Laravel_</span>'s powered API for article searching and storing.

## Result messages & codes

### Login

| Code | Message               | Explanation                                                                |
| ---- | --------------------- | -------------------------------------------------------------------------- |
| 1001 | Login successfull     | The log in operation was done successfull                                  |
| 1002 | Credentials not match | The given credentials doesn't match with any of database users credentials |
| -    | -                     | -                                                                          |
| 1099 | Unknown error         | The given error was unknown and needs to be investaged                     |


### Register

| Code | Message              | Explanation                                            |
| ---- | -------------------- | ------------------------------------------------------ |
| 1101 | Register successfull | The register operation was done successfull            |
| 1102 | Email already exists | The given email already exists in database             |
| -    | -                    | -                                                      |
| 1199 | Unknown error        | The given error was unknown and needs to be investaged |
