# Web Programmer Test Project

## Get Started

- Set up `.env` file within `php-code-test` file
  ```
  export HOST=<host>
  export USERNAME=<user>
  export PASSWORD=<password>
  export SCHEMA=<schema holding sweetwater_test>
  ```
- Start project from terminal/shell:
  - source the `.env` file: `source .env`
  - run: `php -S 127.0.0.1:8000`

## Intro

Thanks for your interest in working at Sweetwater! We're always excited to meet awesome people. We've created this test to help us understand your programming chops.

When placing orders on a website, we provide a field for customers to add a quick comment to tell us something we should know about them or their order. We're supplying you a MySQL table with these various comments and want to see your approach the following tasks.

## Task 1 - Write a report that will display the comments from the table

Display the comments and group them into the following sections based on what the comment was about:

- Comments about candy
- Comments about call me / don't call me
- Comments about who referred me
- Comments about signature requirements upon delivery
- Miscellaneous comments (everything else)

## Task 2 - Populate the shipdate_expected field in this table with the date found in the `comments` field (where applicable)

The shipdate_expected field is currently populated with no date (0000-00-00). Some of comments included an "Expected Ship Date" in the text. Please parse out the date from the text and properly update the shipdate_expected field in the table

## How you'll build it

- You can use any VCS platform you like — such as Gitlab or Github — as long as your project is publicly accessible.
- Build your application so we can test it in-browser.
- Write your application using PHP
- We're interested in functionality, not design. It doesn't have to look pretty but your code should :-)
- Don't use any other JavaScript libraries, such as jQuery.
- Once you're done, send us the link to your project so we can look it over.

## Requirements

- **Commit often.** We want to see your progress throughout the project.
- **Work quickly.** This project was designed to be completed quickly, so don't spend too much time on it.
- **Write your own code.** While we understand that there are pakages out there that take care of common problems, we ultimately want to see what _YOU_ can build, not what someone else has built.
- **Do your best work.** We're using this project as a viewport into who you are as a developer. Show us what you can do!
