/**
 * @return - Boolean
 * @description
 * Returns true, if the course code starts with 3 characters and then 4 digits
 * Returns false, if the course code follows any other format
 * @example
 * SCS1234 / ABC1234 - true
 * ABC12345 / #BC1234 - false
 * @param {string} course_code - course code which need to check
 */
function validate_course_code(course_code) {
    /*
    ^ matches the start of the string
    [A-Z] matches any uppercase letter
    {2} specifies that exactly 2 uppercase letters should be matched
    \s matches any whitespace character
    \d matches any digit
    {4} specifies that exactly 4 digits should be matched
    $ matches the end of the string
     */
    const re = new  RegExp("^[A-Z]{2}\\s\\d{4}$");
    return re.test(course_code);
}

/**
 * @return - Boolean
 * @description
 * Returns true, if the text only contains characters or numbers
 * Returns false, if the text follows any other format
 * @example
 * Science12 / 12Scienc1e - true
 * #Science / Code/3 - false
 * @param {string} text - text which need to check
 */
function validate_non_special_character_text(text) {
    /*
    a-z matches any lowercase letter from a to z.
    A-Z matches any uppercase letter from A to Z.
    0-9 matches any digit from 0 to 9.
     */
    const re = new RegExp("[a-zA-Z0-9]");
    return re.test(text);
}

/**
 * @return - boolean
 * @description
 * Returns `true` if the email address is valid
 * return `false` otherwise.
 * @example
 * "example@example.com" - true
 * "invalid-email@" - false
 * @param {string} email - The email address to validate.
 */
function validate_email(email){
    /*
    ^ matches the beginning of the string
    ^\s@]+ matches one or more characters that are not whitespace or the "@" symbol
    @ matches the "@" symbol.
    [^\s@]+ matches one or more characters that are not whitespace or the "@" symbol
    \. matches a "." character
    $ the end of the string.
     */
    const re = new  RegExp("^[^\\s@]+@[^\\s@]+\\.[^\\s@]+$");
    return re.test(email);
}

/**
 * @param contact - the phone number to validate
 * @returns {boolean} - true if the phone number is valid, false otherwise
 * @description
 * Returns true if the phone number is valid in one of the following formats:
 * Starts with a "+" sign followed by exactly 11 digits
 * Consists of exactly 10 digits
 * Returns false otherwise.
 * @example
 * validate_contact("0715674327") - true
 * validate_contact("05D5357543we") - false
 */
function validate_contact(contact){
    /*
    \d matches any digit
    {10} specifies that exactly 10 digits should be matched
    ^ matches the start of the string
    $ matches the end of the string
     */
    const re = /^(?:\+\d{11}|\d{10})$/;
    return re.test(contact);
}

/**
 * @param {string} password - The password to validate.
 * @returns {boolean} - `true` if the password meets the criteria, `false` otherwise.
 * @description Returns `true` if the password meets the following criteria, and `false` otherwise:
 * @example
 * validate_password("P@ssw0rd") - true
 * validate_password("password") - false
 */
function validate_password(password) {
     /*
    ^[^\s@]+ - Matches one or more characters that are not whitespace or "@"
    @ - Matches the "@" symbol
    [^\s@]+ - Matches one or more characters that are not whitespace or "@"
    \. - Matches the dot symbol
    [^\s@]+$ - Matches one or more characters that are not whitespace or "@", at the end of the string
     */
    const re = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]).{8,}$/;
    return re.test(password);
}