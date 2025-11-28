// CustomHeader.tsx
import React from "react"
import {
  View,
  Text,
  TouchableOpacity,
  StyleSheet,
  StatusBar,
  Platform,
} from "react-native"
import { SafeAreaView } from "react-native-safe-area-context"
import { Ionicons } from "@expo/vector-icons"
import { DrawerActions, useNavigation } from "@react-navigation/native"
import * as Animatable from "react-native-animatable"

interface CustomHeaderProps {
  title: string
  showMenuButton?: boolean
  showBackButton?: boolean
}

const CustomHeader: React.FC<CustomHeaderProps> = ({
  title,
  showMenuButton = true,
  showBackButton = false,
}) => {
  const navigation = useNavigation<any>()

  const openDrawer = () => {
    navigation.dispatch(DrawerActions.openDrawer())
  }

  const goBack = () => {
    if (navigation.canGoBack()) {
      navigation.goBack()
    }
  }

  return (
    <>
      {/* Forzamos status bar transparente + texto claro */}
      <StatusBar
        backgroundColor="transparent"
        translucent={true}
        barStyle="light-content"
      />

      {/* SafeAreaView solo para el área superior */}
      <SafeAreaView edges={["top"]} style={{ backgroundColor: "#4B9CDB" }}>
        <Animatable.View
          animation={{
            from: { backgroundColor: "#4B9CDB" },
            to: { backgroundColor: "#87CEEB" },
          }}
          iterationCount="infinite"
          direction="alternate-reverse"
          duration={5000}
          easing="ease-in-out"
          style={styles.headerContainer}
        >
          <View style={styles.headerContent}>
            {/* Botón Volver */}
            <View style={styles.leftContainer}>
              {showBackButton && (
                <TouchableOpacity style={styles.backButton} onPress={goBack}>
                  <Ionicons name="arrow-back" size={32} color="#FFFFFF" />
                </TouchableOpacity>
              )}
            </View>

            {/* Título centrado */}
            <View style={styles.textContainer}>
              <Text style={styles.title}>DENTAL SMILE</Text>
              <Text style={styles.subtitle}>{title}</Text>
            </View>

            {/* Botón Menú */}
            <View style={styles.rightContainer}>
              {showMenuButton && (
                <TouchableOpacity style={styles.menuButton} onPress={openDrawer}>
                  <Ionicons name="menu" size={34} color="#FFFFFF" />
                </TouchableOpacity>
              )}
            </View>
          </View>
        </Animatable.View>
      </SafeAreaView>
    </>
  )
}

const styles = StyleSheet.create({
  headerContainer: {
    backgroundColor: "#4B9CDB",
    paddingVertical: 16,
    paddingHorizontal: 12,
    paddingTop: Platform.OS === "android" ? 10 : 0, // Extra padding en Android si hace falta
    flexDirection: "row",
    alignItems: "center",
    justifyContent: "space-between",
    elevation: 4,
    shadowColor: "#000",
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.2,
    shadowRadius: 4,
  },
  headerContent: {
    flexDirection: "row",
    alignItems: "center",
    width: "100%",
  },
  leftContainer: {
    width: 50,
    alignItems: "flex-start",
  },
  rightContainer: {
    width: 50,
    alignItems: "flex-end",
  },
  textContainer: {
    flex: 1,
    alignItems: "center",
    justifyContent: "center",
  },
  title: {
    color: "#FFFFFF",
    fontSize: 20,
    fontWeight: "800",
    letterSpacing: 1,
  },
  subtitle: {
    color: "#E0F7FA",
    fontSize: 16,
    fontWeight: "600",
    marginTop: 2,
  },
  backButton: {
    padding: 8,
    borderRadius: 20,
    backgroundColor: "rgba(255,255,255,0.15)",
  },
  menuButton: {
    padding: 8,
    borderRadius: 20,
    backgroundColor: "rgba(255,255,255,0.15)",
  },
})

export default CustomHeader