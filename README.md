# Kagescan.fr (v2) source code

The Kagescan project is first and foremost a website born from a well-defined philosophy. However, the project has gradually lost its mentality and since 2019, there has been no real development activity.

A total redesign of the site is therefore planned for the 5th anniversary of this project (February 14, 2022) with the following objectives:

- A minimal but very fast website (effort to make as few requests as possible at the client level, SPA or serverless concepts are counterexamples)
- A low cost deployable php website (suitable for a free shared hosting), maintainable by small groups of fans
- Tools to create, organize and publish translations of all kinds (manga pages as well as light novel texts)
- More recently, a will to respect privacy (going beyond a legal site by using as few cookies as possible and not relying on third party tools such as AddThis or Google Analytics) and the ability to localize the website's content

Currently, we are doing some upstream work for the realization of this new project, including self-training to make a rigorously stable and secure site.  
Any help is appreciated, contact <logan@kagescan.fr> for more information

## Running and developping the app

### Dependancies

We are using the CodeIgniter 4 framework. It have been installed without composer so all you have to do is ...

* Having php 8.0 or above (required is php 7.2 but I might try some php8.0 features in the future)
* Activating the following extensions : `intl`, `mbstring`, `GD`
* Following the steps below.


### Running Kagescan-cms

Actually, the code have been written within the CodeIgniter development server, and still have not been tested in a remote apache server.
Fun fact : In contrary, the first version of kagescan have been developed mainly inside the production server (It's not a good practice though).

CodeIgniter provides a complete documentation page about [how to run the app](https://codeigniter.com/user_guide/installation/running.html), but here is a short summary :

<table> <th> <td>Run using a local server</td><td>Run from a remote apache server</td> </th> <tr>
<td>

* Copy the `sample.env` to `.env` and edit it to configure the App. Keep that file secret !
* Execute `php spark serve`
* Local dev server is at `localhost:8080/`

</td>
<td>


* Copy the `sample.env` to `.env` and edit it to configure the App. Keep that file secret !
* The apache document root folder should point to the `public/` folder

</td>
</tr> </table>

### Editing the code

Kagescan-cms' fresh install almost follows CodeIgniter4 default structure and has five directories :

* The **App/** directory is where all of the application's code lives.
* The **src/** contains symbolic links that points to the most used folders and files inside the `App` directory. It's just a folder that acts as a shortcut to get a better focus on the classic MVC structure :
	* `src/Models` : manages the data of the application and enforces rules.
	* `src/Views` : make up the HTML that is displayed to the client.
	* `src/Controllers` : Handles the logic of the request by fetching data from the models and displaying the correct views.
	* `src/Routes.php` : Maps a request to a controller's method.
* The **public/** folder is meant to be the “web root” of your site, and your web server would be configured to point to it. It holds the browser-accessible portion of the application, such as assets like CSS or Javascript files.
* The **writable/** directory holds any directories that might need to be written to in the course of the application’s life. This allows you to keep your other primary directories non-writable as an added security measure
* The **system/** directory stores the files that make up the framework, itself. While you have a lot of flexibility in how you use the application directory, the files in the system directory should never be modified.

## Security

Unfortunately, we don't provide any bug bounty nor reward policy. Keep in mind that Kagescan is being developed by a poor 1st grade student.

Kagescan is actually hosted in France and french laws applies : Ask authorization before starting a pentest, and if you have found a vulnerability, contact me using <my github public e-mail> instead of submitting a github issue. Note : You might not get a fast reply by using kagescan's official email.
