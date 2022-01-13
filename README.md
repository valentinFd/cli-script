logo
Hello {candidate.name},

Welcome to Fly Now Pay Later!

This page will provide you with your homework assignment for the PHP web developer position.

In this assignment, you must evaluate the input file contents and locate the first non-repeating, least repeating or most repeating letter, punctuation and symbol based on the given instructions.

You will create a command-line script that can accept various input flags, parse the contents and output a result.

Condition #1

When a flag -i or --input is provided, verify that the value for the passed argument is a path to a file that exists. If there is no flag, or the file path provided does not exist, exit with error code 1.

Verify that the file contents contain lower case alphabet ASCII letters, punctuations and symbols only. If the file does not contain any of the mentioned or has other forms of characters (newlines or spaces, for example), exit with error code 2;

Condition #2

When the flag -f or --format is provided, verify that this flag contains a value of non-repeating, least-repeating, or most-repeating. If there is no flag provided, or the provided value does not meet the specified values, exit with error code 3.

Condition #3

At least one of the following flags must be provided:

-L, --include-letter
-P, --include-punctuation
-S, --include-symbol
If all flags are provided, you must execute all conditions, whilst if none of the execution flags is present, exit with error code 4.

Condition #4

The output of the command-line script must give a sentence of what it is doing, few examples:

script.php -i file.txt -f non-repeating -L
> File: file.txt
> First non-repeating letter: z

script.php -i file.txt -f least-repeating -S -L
> File: file.txt
> First least repeating symbol: @
> First least repeating letter: m

script.php -i file.txt -f most-repeating -P -L -S
> File: file.txt
> First most repeating punctuation: !
> First most repeating symbol: @
> First most repeating letter: m

If condition not found, use result None, for example:

script.php -i file.txt -f least-repeating -L
> File: file.txt
> First least repeating letter: None
Condition #5

You must write a unit test using PHPUnit covering 100% of the code you've written.

Finally

Pay attention to your execution speed, CPU consumption and ram usage, as we'll be looking at your creative ways of optimising your code.

Also, your script does not need to be condensed in one file, be free to use any framework / oop structure - all is allowed.

To help you succeed, we built our own version of this task that you can use to verify your result. Click here (https://www.flynowpaylater.com/hiring/candidates/php-developer/assignment/?form) to try.

Best of luck,
Fly Now Pay Later
