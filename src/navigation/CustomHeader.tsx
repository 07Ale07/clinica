import React from 'react';
import { View, Text, TouchableOpacity, StyleSheet } from 'react-native';
import { Ionicons } from '@expo/vector-icons';
import { DrawerActions, useNavigation } from '@react-navigation/native';
import * as Animatable from 'react-native-animatable';

interface CustomHeaderProps {
  title: string;
  showMenuButton?: boolean;
  showBackButton?: boolean;
}

const CustomHeader: React.FC<CustomHeaderProps> = ({ title, showMenuButton = true, showBackButton = false }) => {
  const navigation = useNavigation();

  const openDrawer = () => {
    navigation.dispatch(DrawerActions.openDrawer());
  };

  const goBack = () => {
    if (navigation.canGoBack()) {
      navigation.goBack();
    }
  };

  return (
    <Animatable.View
      style={styles.headerContainer}
      animation={{
        from: { backgroundColor: '#4B9CDB' },
        to: { backgroundColor: '#87CEEB' },
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
  );
};

const styles = StyleSheet.create({
  headerContainer: {
    backgroundColor: '#4B9CDB', // Fallback color
    paddingTop: 12,
    paddingBottom: 22,
    paddingHorizontal: 20,
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 4 },
    shadowOpacity: 0.3,
    shadowRadius: 8,
    elevation: 6,
  },
  headerContent: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
  },
  leftContainer: {
    minWidth: 40,
  },
  rightContainer: {
    minWidth: 40,
  },
  backButton: {
    padding: 6,
  },
  menuButton: {
    padding: 6,
  },
  textContainer: {
    flex: 1,
    alignItems: 'center',
  },
  title: {
    fontSize: 30,
    fontWeight: 'bold',
    color: '#FFFFFF',
    textShadowColor: 'rgba(0, 0, 0, 0.3)',
    textShadowOffset: { width: 1, height: 1 },
    textShadowRadius: 5,
  },
  subtitle: {
    fontSize: 16,
    color: '#F5F8FA',
    marginTop: 6,
    fontWeight: '500',
    textShadowColor: 'rgba(0, 0, 0, 0.2)',
    textShadowOffset: { width: 1, height: 1 },
    textShadowRadius: 3,
  },
});

export default CustomHeader;