import {PADDING} from '~/constants/spacing'
import {FONT_SIZES, LINE_HEIGHTS, FONT_WEIGHTS, FONT_FAMILY} from '~/constants/fonts'
import {BUTTON_BACKGROUND, BUTTON_TEXT} from '~/constants/colours'

export const style = {
  button: {
    borderRadius: 0,
    border: 'none',
    marginTop: PADDING.D2,
    marginBottom: PADDING.D2,
    fontSize: FONT_SIZES.SMALL,
    lineHeight: 1,
    margin: 0,
    padding: PADDING.D2,
    fontFamily: FONT_FAMILY,
    fontWeight: FONT_WEIGHTS.LIGHT,
    width: 150,
    display: 'block',
    background: BUTTON_BACKGROUND,
    color: BUTTON_TEXT,
    cursor: 'pointer',
    height: FONT_SIZES.SMALL + PADDING.X1
  }
}
