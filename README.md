# Kagescan.fr (v2) source code

The Kagescan project is first and foremost a website born from a well-defined philosophy. However, the project has gradually lost its mentality and since 2019, there has been no real development activity.

A total redesign of the site is therefore planned for the 5th anniversary of this project (February 14, 2020) with the following objectives:

- A minimal but very fast website (effort to make as few requests as possible at the client level, SPA or serverless concepts are counterexamples)
- A low cost deployable php website (suitable for a free shared hosting), maintainable by small groups of fans
- Tools to create, organize and publish translations of all kinds (manga pages as well as light novel texts)
- More recently, a will to respect privacy (going beyond a legal site by using as few cookies as possible and not relying on third party tools such as AddThis or Google Analytics) and the ability to localize the website's content

Currently, we are doing some upstream work for the realization of this new project, including self-training to make a rigorously stable and secure site.  
Any help is appreciated, contact <logan@kagescan.fr> for more information

## Dependancies

We are using the CodeIgniter 4 framework. It have been installed without composer so all you have to do is ...

* Having php 8.0 or above (required is php 7.2 but I'll prob. try php8.0 features)
* Activating the following extensions : `intl`, `mbstring`, `GD`
* Following the steps below.

## Local dev.

Actually, the code have been written within the CodeIgniter development server, and have not been tested in a remote apache server.

Steps to run the code :

* Move to the `framework-4.1.3` folder
* Run `php spark serve`
* Local dev server is at `localhost:8080/`

## Remote dev.

The fist version of kagescan have been developed mainly inside the production server rather than a local webserver. It's not a good practice though.

Section content to be added once we achieve it.

## Security

Unfortunately, we don't provide any bug bounty nor reward policy. Keep in mind that Kagescan is being developed by a poor 1st grade student.

Kagescan is actually hosted in France and french laws applies : Ask authorization before starting a pentest, and if you have found a vulnerability, contact me using <my github public e-mail> instead of submitting a github issue. You might not get a fast reply by using kagescan's email.
