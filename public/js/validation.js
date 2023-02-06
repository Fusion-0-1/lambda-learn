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
    {3} specifies that exactly 3 uppercase letters should be matched
    \d matches any digit
    {4} specifies that exactly 4 digits should be matched
    $ matches the end of the string
     */
    const re = new  RegExp("^[A-Z]{3}\\d{4}$");
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