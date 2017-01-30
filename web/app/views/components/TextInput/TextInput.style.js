import {PADDING} from '~/constants/spacing'
import {FONT_SIZES, LINE_HEIGHTS, FONT_WEIGHTS, FONT_FAMILY} from '~/constants/fonts'

export const style = {
  input: {
    flex: 1,
    padding: PADDING.D2,
    fontSize: FONT_SIZES.SMALL,
    lineHeight: LINE_HEIGHTS.SMALL,
    margin: 0,
    fontFamily: FONT_FAMILY,
    fontWeight: FONT_WEIGHTS.LIGHT
  },

  container: {
    display: 'flex',
    marginBottom: PADDING.D2,
    marginTop: PADDING.D2,
    flex: 1
  }
}
