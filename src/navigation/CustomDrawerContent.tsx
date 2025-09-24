import React, { useState, useEffect } from 'react';
import { View, Text, Image, TouchableOpacity, StyleSheet } from 'react-native';
import { DrawerContentScrollView } from '@react-navigation/drawer';
import { useNavigation } from '@react-navigation/native';
import { StackNavigationProp } from '@react-navigation/stack';
import { Ionicons } from '@expo/vector-icons';
import AsyncStorage from '@react-native-async-storage/async-storage';
import * as Animatable from 'react-native-animatable';
import { LinearGradient } from 'expo-linear-gradient';
import { RootStackParamList } from './types';

type DrawerNavigationProp = StackNavigationProp<RootStackParamList>;

interface UserData {
  username: string;
  fullName: string;
  jobTitle: string;
  profilePicture?: string;
}

const CustomDrawerContent: React.FC<any> = (props) => {
  const navigation = useNavigation<DrawerNavigationProp>();
  const [userData, setUserData] = useState<UserData>({
    username: '',
    fullName: '',
    jobTitle: '',
    profilePicture: undefined,
  });
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const fetchUserData = async () => {
      try {
        const id_usuario = await AsyncStorage.getItem('id_usuario');
        const username = await AsyncStorage.getItem('username');
        const fullName = await AsyncStorage.getItem('fullName');
        const jobTitle = await AsyncStorage.getItem('jobTitle');
        console.log('Datos obtenidos de AsyncStorage:', { id_usuario, username, fullName, jobTitle });

        if (!id_usuario || id_usuario === 'null') {
          console.warn('No se encontró id_usuario en AsyncStorage, redirigiendo a Login');
          navigation.navigate('Login');
          return;
        }

        setUserData({
          username: username || 'Usuario',
          fullName: fullName || 'Nombre Completo',
          jobTitle: jobTitle || 'Usuario',
          profilePicture: undefined, // No profile picture stored in login response
        });
      } catch (error: any) {
        console.error('Error fetching user data from AsyncStorage:', error.message || error);
        setUserData({
          username: 'Usuario',
          fullName: 'Nombre Completo',
          jobTitle: 'Usuario',
          profilePicture: undefined,
        });
      } finally {
        setLoading(false);
      }
    };
    fetchUserData();
  }, [navigation]);

  const handleLogout = async () => {
    try {
      await AsyncStorage.multiRemove(['id_usuario', 'username', 'fullName', 'jobTitle']);
      console.log('Datos eliminados de AsyncStorage, redirigiendo a Login');
      navigation.navigate('Login');
    } catch (error) {
      console.error('Error during logout:', error);
    }
  };

  return (
    <DrawerContentScrollView {...props} contentContainerStyle={styles.drawerContainer}>
      <LinearGradient colors={['#4B9CDB', '#2A6EBB']} style={styles.profileContainer}>
        <Animatable.View animation="zoomIn" duration={1000}>
          {loading ? (
            <View style={styles.profilePicturePlaceholder}>
              <Ionicons name="person-circle-outline" size={100} color="#FFFFFF" />
            </View>
          ) : (
            <Image
              source={{ uri: userData.profilePicture || 'https://via.placeholder.com/150' }}
              style={styles.profilePicture}
              defaultSource={{ uri: 'https://via.placeholder.com/150' }}
            />
          )}
          <Text style={styles.username}>{userData.username}</Text>
          <Text style={styles.fullName}>{userData.fullName}</Text>
          <Text style={styles.jobTitle}>{userData.jobTitle}</Text>
        </Animatable.View>
      </LinearGradient>
      <View style={styles.menuItems}>
        <TouchableOpacity style={styles.logoutButton} onPress={handleLogout}>
          <LinearGradient colors={['#E63946', '#FF6B6B']} style={styles.logoutButtonGradient}>
            <Ionicons name="log-out-outline" size={24} color="#FFFFFF" style={styles.logoutIcon} />
            <Text style={styles.logoutButtonText}>Cerrar Sesión</Text>
          </LinearGradient>
        </TouchableOpacity>
      </View>
    </DrawerContentScrollView>
  );
};

const styles = StyleSheet.create({
  drawerContainer: {
    flex: 1,
    backgroundColor: '#F7FAFD',
  },
  profileContainer: {
    padding: 30,
    alignItems: 'center',
    borderBottomLeftRadius: 20,
    borderBottomRightRadius: 20,
  },
  profilePicture: {
    width: 100,
    height: 100,
    borderRadius: 50,
    marginBottom: 15,
    borderWidth: 3,
    borderColor: '#FFFFFF',
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.3,
    shadowRadius: 4,
  },
  profilePicturePlaceholder: {
    width: 100,
    height: 100,
    borderRadius: 50,
    backgroundColor: '#E6F0FA',
    justifyContent: 'center',
    alignItems: 'center',
    marginBottom: 15,
    borderWidth: 3,
    borderColor: '#FFFFFF',
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.3,
    shadowRadius: 4,
  },
  username: {
    fontSize: 20,
    fontWeight: '700',
    color: '#FFFFFF',
    textAlign: 'center',
  },
  fullName: {
    fontSize: 16,
    color: '#E6F0FA',
    textAlign: 'center',
    marginTop: 5,
  },
  jobTitle: {
    fontSize: 14,
    color: '#D1E6F9',
    textAlign: 'center',
    marginTop: 5,
  },
  menuItems: {
    padding: 20,
  },
  logoutButton: {
    borderRadius: 10,
    overflow: 'hidden',
    marginTop: 20,
  },
  logoutButtonGradient: {
    flexDirection: 'row',
    alignItems: 'center',
    paddingVertical: 12,
    paddingHorizontal: 20,
  },
  logoutIcon: {
    marginRight: 10,
  },
  logoutButtonText: {
    fontSize: 16,
    fontWeight: '600',
    color: '#FFFFFF',
  },
});

export default CustomDrawerContent;