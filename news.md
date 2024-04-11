### Technical Challange PHP

##### We have the following JSON file which contains news articles from 2022 along with some information about each article.
[news.json](data/news.json)
##### You need to create a Rest API microservice, without authentication, which imports data from the JSON file and exposes the following endpoint for consumers:

* GET: `api/news/{date: dd.mm.yyyy}`
    * Ex: `localhost/api/news/24.09.2022`
    * Response Type: `application/json`
    * Return all articles published on that date (see the `pub_date` field).
    * If there are exceptions or invalid data, it is up to you how to approach them.
    * The mapping of fields in the response will be done as follows:
  ```js
        {
            "title": string, // Content of the ABSTRACT field from the JSON file.
            "short": string, // Content of the LEAD_PARAGRAPH field from the JSON file.
            "source": string, // Content of the SOURCE field from the JSON file.
            "category": string, // Content of the SECTION_NAME field from the JSON file.
            "subCategory": string, // Content of the SUBSECTION_NAME field from the JSON file.
            "author": string, // Concatenation (firstname middlename lastname) of the BYLINE field from the JSON. If there are multiple authors, only the first one will be returned!
            "link": string // Content of the WEB_URL field from the JSON file.
        }
  ```
    * An example of the expected response, based on the previous specifications, would look like this:
  ```json 
  {
    "totalResults": 3,
    "news" : [
        {
            "title": "The demand for repurposed ...",
            "short": "Until recently, I had never realized...",
            "source": "The New York Times",
            "category": "World",
            "subCategory": "Europe",
            "author": "Tripp Mickle",
            "link": "https://www.nytimes.com/2022/06/30/business/apple-levoff-insider-trading.html"
        },
        {
            "title": "The demand for repurposed ...",
            "short": "Until recently, I had never realized...",
            "source": "The New York Times",
            "category": null,
            "subCategory": null,
            "author": "Tripp Mickle",
            "link": "https://www.nytimes.com/2022/06/30/business/apple-levoff-insider-trading.html"
        } ,
        {
            "title": "The demand for repurposed ...",
            "short": "Until recently, I had never realized...",
            "source": "The New York Times",
            "category": "Style",
            "subCategory": null,
            "author": "Tripp Mickle",
            "link": "https://www.nytimes.com/2022/06/30/business/apple-levoff-insider-trading.html"
        } 
    ]
  }
  ```

#### PHP vanilla or any existing framework can be used.
#### Modules available on https://packagist.org/ can be used.
#### Any form of data storage from the JSON file can be used (any type of database).
### The provided solution will be evaluated based on:
* Coding Standards
* Naming Conventions
* Project Structure
* Meeting the requirements

### Extra points:
* Any improvements made to the solution will earn extra points in the evaluation.
* Nice to have:
    * Frontend client that consumes the data provided by the microservice.
