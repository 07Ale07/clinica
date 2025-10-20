import { Animated, Easing } from "react-native"

export const createFadeInAnimation = (animatedValue: Animated.Value, duration = 400) => {
  return Animated.timing(animatedValue, {
    toValue: 1,
    duration,
    easing: Easing.out(Easing.cubic),
    useNativeDriver: true,
  })
}

export const createSlideInAnimation = (animatedValue: Animated.Value, duration = 400) => {
  return Animated.timing(animatedValue, {
    toValue: 0,
    duration,
    easing: Easing.out(Easing.cubic),
    useNativeDriver: true,
  })
}

export const createScaleAnimation = (animatedValue: Animated.Value, toValue = 1, duration = 300) => {
  return Animated.spring(animatedValue, {
    toValue,
    friction: 8,
    tension: 40,
    useNativeDriver: true,
  })
}

export const createPulseAnimation = (animatedValue: Animated.Value) => {
  return Animated.sequence([
    Animated.timing(animatedValue, {
      toValue: 1.05,
      duration: 150,
      easing: Easing.out(Easing.ease),
      useNativeDriver: true,
    }),
    Animated.timing(animatedValue, {
      toValue: 1,
      duration: 150,
      easing: Easing.in(Easing.ease),
      useNativeDriver: true,
    }),
  ])
}
