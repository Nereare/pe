CREATE FUNCTION GET_EXERPT(str MEDIUMTEXT)
RETURNS MEDIUMTEXT
RETURN REPLACE(
  SUBSTRING(
    SUBSTRING_INDEX(str, '<!-- Read More -->', 1),
    CHAR_LENGTH(
        SUBSTRING_INDEX(str, '<!-- Read More -->', 0)
    ) + 1),
  '<!-- Read More -->',
  '');
