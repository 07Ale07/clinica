import type React from "react"
import { View, Text, TouchableOpacity, StyleSheet } from "react-native"
import { Ionicons } from "@expo/vector-icons"
import { DrawerActions, useNavigation } from "@react-navigation/native"
import * as Animatable from "react-native-animatable"

interface CustomHeaderProps {
  title: string
  showMenuButton?: boolean
  showBackButton?: boolean
}

const CustomHeader: React.FC<CustomHeaderProps> = ({ title, showMenuButton = true, showBackButton = false }) => {
  const navigation = useNavigation()

  const openDrawer = () => {
    navigation.dispatch(DrawerActions.openDrawer())
  }

  const goBack = () => {
    if (navigation.canGoBack()) {
      navigation.goBack()
    }
  }

  const styles = StyleSheet.create({
    headerContainer: {
      backgroundColor: "#4B9CDB",
      paddingVertical: 20,
      paddingHorizontal: 10,
      flexDirection: "row",
      alignItems: "center",
      justifyContent: "space-between",
    },
    headerContent: {
      flexDirection: "row",
      alignItems: "center",
      justifyContent: "space-between",
      flex: 1,
    },
    leftContainer: {
      alignItems: "flex-start",
    },
    backButton: {
      padding: 10,
    },
    textContainer: {
      alignItems: "center",
      flex: 1,
    },
    title: {
      color: "#FFFFFF",
      fontSize: 24,
      fontWeight: "bold",
    },
    subtitle: {
      color: "#FFFFFF",
      fontSize: 18,
    },
    rightContainer: {
      alignItems: "flex-end",
    },
    menuButton: {
      padding: 10,
    },
  })

  return (
    <Animatable.View
      style={styles.headerContainer}
      animation={{
        from: { backgroundColor: "#4B9CDB" },
        to: { backgroundColor: "#87CEEB" },
      }}
      iterationCount="infinite"
      direction="alternate"
      duration={4000}
      easing="ease-in-out"
    >
      <View style={styles.headerContent}>
        <View style={styles.leftContainer}>
          {showBackButton && (
            <TouchableOpacity style={styles.backButton} onPress={goBack}>
              <Ionicons name="arrow-back" size={30} color="#FFFFFF" />
            </TouchableOpacity>
          )}
        </View>
        <View style={styles.textContainer}>
          <Text style={styles.title}>DENTAL SMILE</Text>
          <Text style={styles.subtitle}>{title}</Text>
        </View>
        <View style={styles.rightContainer}>
          {showMenuButton && (
            <TouchableOpacity style={styles.menuButton} onPress={openDrawer}>
              <Ionicons name="menu-outline" size={30} color="#FFFFFF" />
            </TouchableOpacity>
          )}
        </View>
      </View>
    </Animatable.View>
  )
}

export default CustomHeader
